<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property string $id
 * @property string $content
 * @property integer $status
 * @property string $create_time
 * @property string $userid
 * @property string $email
 * @property string $url
 * @property string $post_id
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content'], 'string'],
            [['status', 'create_time', 'userid', 'post_id'], 'integer'],
            [['email', 'url'], 'string', 'max' => 128],            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '内容',
            'status' => '状态',
            'create_time' => '创建时间',
            'userid' => '用户Id',
            'email' => '邮箱',
            'url' => 'Url',
            'post_id' => '文章 ',
        ];
    }
    
    public function getBeginning()
    {
        $tmpStr = strip_tags($this->content);
        $tempLen = mb_strlen($tmpStr);
        return mb_substr($tmpStr, 0,10,'utf8') . ($tempLen>10 ? '...':'');;
    }
    
    public function getStatus0()
    {
        return $this->hasOne(Commentstatus::className(), ['id' => 'status']);
    }
    
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }
    
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }
    
    public function approve()
    {
        $this->status = 2;
        return ($this->save() ? true : false);
    }
    
    public static function getPengdingCommentCount()
    {
        return Comment::find()->where(['status'=>1])->count();
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->create_time = time();
            }
            
            return true;
        }else {
            return false;
        }
    }
}
