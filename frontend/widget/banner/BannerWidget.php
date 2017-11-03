<?php

namespace frontend\widget\banner;

use yii\base\Widget;
use Yii;
use yii\helpers\Url;

class BannerWidget extends Widget
{
    
    private $item = [];
    
    public function init()
    {
        $this->item = [
            ['content' => '<img src=' . Yii::$app->request->baseUrl . '/statics/images/banner/b1.jpg>'],
            ['content' => '<img src=' . Yii::$app->request->baseUrl . '/statics/images/banner/b2.jpg>',],
            ['content' => '<img src=' . Yii::$app->request->baseUrl . '/statics/images/banner/b3.jpg>',],
            
//            ['label' => 'demo', 'image_url' => Yii::$app->request->baseUrl.'/statics/images/banner/b1.jpg'],
//            ['label' => 'demo', 'image_url' => Yii::$app->request->baseUrl.'/statics/images/banner/b2.jpg'],
//            ['label' => 'demo', 'image_url' => Yii::$app->request->baseUrl.'/statics/images/banner/b3.jpg'],
        ];
    }
    
    
    public function run()
    {
        $data['items'] = $this->item;
        return $this->render('index',['data'=>$data]);
    }
    
    
    
}
?>