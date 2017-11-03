<?php

namespace common\models;

use common\models\base\BaseModel;
use Yii;

/**
 * This is the model class for table "category".
 *
 * @property string $id
 * @property string $cat_name
 * @property string $pid
 */
class CategoryModel extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_name', 'pid'], 'required'],
            [['pid'], 'integer'],
            [['cat_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cat_name' => Yii::t('app', 'Cat Name'),
            'pid' => Yii::t('app', 'Pid'),
        ];
    }

    public static function getAllCats()
    {
        $cats = ['0' => '请选择分类'];
        $data = self::find()->asArray()->all();
        if($data){
            foreach($data as $key => $value) {
                $cats[$value['id']] = $value['cat_name'];
            }
        }

        return $cats;
    }
}
