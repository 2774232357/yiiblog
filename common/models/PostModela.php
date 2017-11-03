<?php

namespace common\models;

use common\models\base\BaseModel;
use Yii;
use common\models\RelationPostTagModel;
use common\models\PostExtendModel;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $title
 * @property string $summary
 * @property string $content
 * @property string $label_img
 * @property string $cat_id
 * @property string $user_id
 * @property string $user_name
 * @property integer $is_valid
 * @property string $created_at
 * @property string $updated_at
 */
class PostModela extends BaseModel
{
    const IS_VALID = 1;
    const NO_VALID = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'label_img', 'cat_id', 'user_id', 'created_at'], 'required'],
            [['content'], 'string'],
            [['user_id', 'is_valid', 'created_at', 'updated_at'], 'integer'],
            [['title', 'summary', 'label_img', 'user_name'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'summary' => Yii::t('app', 'Summary'),
            'content' => Yii::t('app', 'Content'),
            'label_img' => Yii::t('app', 'Label Img'),
            'cat_id' => Yii::t('app', 'Cat ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'user_name' => Yii::t('app', 'User Name'),
            'is_valid' => Yii::t('app', 'Is Valid'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * 获取文章关联标签
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRelate()
    {
        return $this->hasMany(RelationPostTagModel::calssName(), ['post_id'=>id]);
    }

    /**
     * 统计关联
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExtend()
    {
        return $this->hasOne(PostExtendModel::className(),['post_id'=>id]);
    }
}
