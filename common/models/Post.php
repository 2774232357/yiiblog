<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property string $id
 * @property string $title
 * @property string $content
 * @property string $tags
 * @property integer $status
 * @property string $cache_time
 * @property string $update_time
 * @property string $author_id
 */
class Post extends \yii\db\ActiveRecord
{
    private $_oldTags;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'tags'], 'required'],
            [['content', 'tags'], 'string'],
            [['status', 'cache_time', 'update_time', 'author_id'], 'integer'],
            [['title'], 'string', 'max' => 128],
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
            'tags' => '标签',
            'status' => '状态',
            'cache_time' => '缓存时间',
            'update_time' => '更新时间',
            'author_id' => '作者 ID',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function getStatus0()
    {
        return $this->hasOne(Poststatus::className(),['id'=>'status']);
    }
    
    /**
     * @inheritdoc
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(),['post_id'=>'id']);
    }
    
    /**
     * @inheritdoc
     */
    public function getAuthor()
    {
        return $this->hasOne(Adminuser::className(),['id'=>'author_id']);
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->cache_time = time();
                $this->update_time = time();
            }else {
                $this->update_time = time();
            }
            return true;
        }else {
            return false;
        }
    }
    
    public function afterFind() 
    {
        parent::afterFind();
        $this->_oldTags = $this->tags;
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        Tag::updateFrequency($this->_oldTags, $this->tags);
    }
    
    public function afterDelete()
    {
        parent::afterDelete();
        Tag::updateFrequency($this->_oldTags, '');
    }
}
