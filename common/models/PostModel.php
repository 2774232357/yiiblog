<?php

namespace common\models;

use Yii;
use common\models\base\BaseModel;

/**
 * This is the model class for table "article".
 *
 * @property string $id
 * @property string $title
 * @property string $summary
 * @property string $content
 * @property string $label_img
 * @property integer $cat_id
 * @property string $user_id
 * @property string $user_name
 * @property integer $is_valid
 * @property string $created_at
 * @property string $updated_at
 */
class PostModel extends BaseModel
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
            [['title', 'summary', 'content', 'cat_id', 'user_id', 'user_name', 'is_valid', 'created_at', 'updated_at'], 'required'],
            [['cat_id', 'user_id', 'is_valid', 'created_at', 'updated_at'], 'integer'],
            [['title', 'summary'], 'string', 'max' => 255],
            [['content'], 'string', 'max' => 1500],
            [['label_img'], 'string', 'max' => 100],
            [['user_name'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'summary' => 'Summary',
            'content' => 'Content',
            'label_img' => 'Label Img',
            'cat_id' => 'Cat ID',
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'is_valid' => 'Is Valid',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    
    /**
     * 获取文章关联标签
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRelate()
    {
        return $this->hasMany(RelationPostTagModel::className(), ['post_id'=>'id']);
    }
    
    
    /**
     * 统计关联
     *
     * @return \yii\db\ActiveQuery
     */
    public function getExtend()
    {
        return $this->hasOne(PostExtendModel::className(),['post_id'=>'id']);
    }
}
