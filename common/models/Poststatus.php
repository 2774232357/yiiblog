<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "poststatus".
 *
 * @property string $id
 * @property string $name
 * @property integer $position
 */
class Poststatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'poststatus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position'], 'integer'],
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
            'position' => 'Position',
        ];
    }
}