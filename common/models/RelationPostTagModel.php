<?php

namespace common\models;

use common\models\base\BaseModel;
use Yii;
use common\models\TagModel;

/**
 * This is the model class for table "article_tag_relation".
 *
 * @property string $id
 * @property string $post_id
 * @property string $tag_id
 */
class RelationPostTagModel extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_tag_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'tag_id'], 'required'],
            [['post_id', 'tag_id'], 'integer'],
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
            'tag_id' => Yii::t('app', 'Tag ID'),
        ];
    }

    /**
     * 博客标签
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(TagModel::className(),['id'=>'tag_id']);
    }
}
