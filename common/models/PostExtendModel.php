<?php

namespace common\models;

use common\models\base\BaseModel;
use Yii;

/**
 * This is the model class for table "articel_extents".
 *
 * @property integer $id
 * @property string $post_id
 * @property string $browser
 * @property string $collect
 * @property string $praise
 * @property string $commit
 */
class PostExtendModel extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_extents';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'browser', 'collect', 'praise', 'commit'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'post_id' => Yii::t('app', 'Article ID'),
            'browser' => Yii::t('app', 'Browser'),
            'collect' => Yii::t('app', 'Collect'),
            'praise' => Yii::t('app', 'Praise'),
            'commit' => Yii::t('app', 'Commit'),
        ];
    }

    /**
     * 统计功能
     * @param $condition
     * @param $attribute
     * @param $num
     */
    /* public function updateCount($condition,$attribute,$num)
    {
        $res = self::find()->where($condition)->one();
        if(!$res){
            $this->setAttributes($condition);
            $this->browser = $num;
            $this->save();
        }else{
            $res->updateCounters([$attribute=>$num]);
        }
    } */
    
    
    public function upCounter($cond,$attribute,$num)
    {
        $counter = $this->findOne($cond);
        if (!$counter) {
            $this->setAttributes($cond);
            $this->$attribute = $num;
            $this->save();
        }else {
            $countData[$attribute] = $num;
            $counter->updateCounters($countData);
        }
    }
}
