<?php

namespace common\models;

use Yii;
use common\models\base\BaseModel;
use common\models\User;

/**
 * This is the model class for table "feeds".
 *
 * @property string $id
 * @property string $user_id
 * @property string $content
 * @property string $created_at
 */
class FeedModel extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feeds';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'content', 'created_at'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['content'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'content' => 'Content',
            'created_at' => 'Created At',
        ];
    }
    
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id'=>'user_id']);
    }
}
