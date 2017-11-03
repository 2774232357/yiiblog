<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property string $id
 * @property string $name
 * @property string $frequency
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'frequency' => 'Frequency',
        ];
    }
    
    public static function string2array($tags)
    {
        return explode(',', $tags);
    }
    
    public static function array2string($tags)
    {
        return implode(',', $tags);
    }
    
    public static function addTags($tags)
    {
        if (empty($tags)) {
            return ;
        }
        
        foreach ($tags as $name) {
            $atag = Tag::find()->where(['name'=>$name])->one();
            $atagCount = Tag::find()->where(['name'=>$name])->count();
            
            if (!$atagCount) {
                $tag = new Tag;
                $tag->name = $name;
                $tag->frequency = 1;
                $tag->save();
            }else {
                $atag->frequency += 1;
                $atag->save();
            }
        }
    }
    
    public static function removeTags($tags)
    {
        if (empty($tags)) {
            return ;
        }
        
        foreach ($tags as $name) {
            $atag = Tag::find()->where(['name'=>$name])->one();
            $atagCount = Tag::find()->where(['name'=>$name])->count();
        
            if ($atagCount) {
                if ($atagCount <=1) {
                    $atag->delete();
                }else {
                    $atag->frequency -= 1;
                    $atag->save();
                }
            }
        }
    }
    
    public static function updateFrequency($oldTags,$newTags)
    {
        if (!empty($oldTags) || !empty($newTags)) {
            $oldTagsArray = self::string2array($oldTags);
            $newTagsArray = self::string2array($newTags);
        }
        
        self::addTags(array_values(array_diff($newTagsArray, $oldTagsArray)));
        self::removeTags(array_values(array_diff($oldTagsArray, $newTagsArray)));
    }
}
