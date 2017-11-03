<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\PostModel;
use common\models\Post;
use yii\base\Object;
use yii\db\Query;
use yii\web\NotFoundHttpException;
use common\models\RelationPostTagModel;
use common\models\PostExtendModel;

/**
 * ContactForm is the model behind the contact form.
 */
class PostForm extends Model 
{
    public $id;
    public $title;
    public $cat_id;
    public $content;
    public $label_img;
    public $tags;
    
    public $_lastError = '';


    //场景设置
    const SCENARIOS_CREATE = 'create';
    const SCENARIOS_UPDATE = 'update';
    
    //事件设置
    const EVENT_AFTER_CREATE = 'eventAfterCreate';
    const EVENT_AFTER_UPDATE = 'eventAfterUpdate';
    
    public function scenarios()
    {
        $scenarios = [
            self::SCENARIOS_CREATE => ['title', 'content', 'cat_id','label_img','tags'],
            self::SCENARIOS_UPDATE => ['title', 'content', 'cat_id','label_img','tags']
        ];
        
        return array_merge(parent::scenarios(), $scenarios);
    }
    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'title', 'content', 'cat_id'], 'required'],
            [['id','cat_id'], 'integer'],
            ['title','string','min'=>5, 'max'=>100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'cat_id' => '分类ID',
            'label_img' => '封面图',
            'tags' => '标签',
        ];
    }
    
    
    /**
     * @inheritdoc
     */
    public function create()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $model = new PostModel();
            $model->setAttributes($this->attributes);
            $model->summary = $this->_getSummary();
            $model->is_valid = PostModel::IS_VALID;
            $model->user_id = Yii::$app->user->identity->id;
            $model->user_name = Yii::$app->user->identity->username;
            $model->created_at = time();
            $model->updated_at = time();
            
            if (!$model->save()) {
                throw new \Exception('fail to save');
            }
            
            $this->id = $model->id;
            $data = array_merge($this->attributes,$model->getAttributes());
            $this->_eventAfterCreate($data);
            
            $transaction->commit();
            return true;
        }catch(\Exception $e){
            $transaction->rollBack();
            $this->_lastError = $e->getMessage();
            return false;
        }
    }
    
    
    /**
     * @inheritdoc
     */
    protected function _getSummary($s=0,$e=90,$char='utf-8')
    {
        if (empty($this->content)) {
            return null;
        }
        
        return mb_substr(str_replace('&nbsp;', '', strip_tags($this->content)), $s,$e,$char);
    }
    
    
    public function _eventAfterCreate($data) 
    {
        $this->on(self::EVENT_AFTER_CREATE,[$this,'_eventAddTag'],$data);
        $this->trigger(self::EVENT_AFTER_CREATE);
    }
    
    
    public function _eventAddTag($event)
    {
        //add tags
        $tagModel = new TagForm();
        $tagModel->tags = $event->data['tags'];
        $tagIds = $tagModel->saveTags();
        
        //delete old relations
        RelationPostTagModel::deleteAll(['post_id'=>$event->data['id']]);
        
        if (!empty($tagIds)) {
            foreach ($tagIds as $k=>$v) {
                $row[$k]['post_id'] = $event->data['id'];
                $row[$k]['tag_id'] = $v;
            }
            
            $res = (new Query())->createCommand()
                                ->batchInsert(RelationPostTagModel::tableName(),['post_id','tag_id'],$row)
                                ->execute();
            
            if (!$res) {
                throw new \Exception ('fail to save');
            }
        }
        
    }
    
    
    public function getViewById($id)
    {
        $data = PostModel::find()->with('relate.tag','extend')->where(['id'=>$id])->asArray()->one();
        if (!$data) {
            throw new NotFoundHttpException('not exist');
        }
        
        //处理标签格式
        if ($data['relate']) {
            foreach ($data['relate'] as $list) {
                $data['tags'][] = $list['tag']['tag_name'];
            }
        }
        
        unset($data['relate']);
        return $data;
    }
    
    
    public static function getList($con, $cond, $curPage = 1, $pageSize = 5, $order = ['id' => SORT_DESC])
    {
        $model = new PostModel();
        $select = ['id', 'title', 'summary', 'label_img', 'cat_id', 'user_id', 'user_name', 'is_valid', 'created_at', 'updated_at'];
        $query = $model->find()
                       ->select($select)
                       ->where($cond)
                       ->andWhere($con)
                       ->with('relate.tag', 'extend')
                       ->orderBy($order);
        //获取分页数据
        $res = $model->getPages($query, $curPage, $pageSize);
    
        //格式化数据
        $res['data'] = self::_formatList($res['data']);
    
        return $res;
    }
    
    public static function _formatList($data)
    {
        foreach ($data as &$list) {
            $list['tags'] = [];
            if (isset($list['relate']) && !empty($list['relate'])) {
                foreach ($list['relate'] as $lt) {
                    $list['tags'][] = $lt['tag']['tag_name'];
    
                }
            }
            unset($list['relate']);
        }
        return $data;
    }
}
