<?php 

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\FeedModel;
use yii\base\Object;
use Zend\View\Model\ViewModel;

class FeedForm extends Model
{
    public $content;
    
    public $_lastError;
    
    
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content'], 'string', 'max' => 255],
        ];
    }
    
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'content' => 'Content',
            'created_at' => 'Created At',
        ];
    }
    
    
    public function getList()
    {
        $model = new FeedModel();
        
        $res = $model->find()
                     ->limit(10)
                     ->with('user')
                     ->orderBy(['id'=>SORT_DESC])
                     ->asArray()
                     ->all();
        
        return $res ? $res : [];
    }
    
    
    public function create()
    {
        try {
            $model = new FeedModel();
            $model->content = trim($this->content);
            $model->user_id = Yii::$app->user->identity->id;
            $model->created_at = time();
            
            if ($model->save()) {
                return true;
            }else {
                throw new \Exception('fail to save');
            }
        }catch (\Exception $e){
            $this->_lastError = $e->getMessage();
            return false;
        }
    }
}
?>