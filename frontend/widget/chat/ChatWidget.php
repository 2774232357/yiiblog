<?php 

namespace frontend\widget\chat;

use yii\base\Widget;
use Yii;
use yii\helpers\Url;
use frontend\models\FeedForm;
use yii\base\Object;

class ChatWidget extends Widget
{
    
    public $aa;
    
    
    public function init()
    {
        
    }
    
    
    public function run()
    {
        $model = new FeedForm();
        
        $data['feed'] = $model->getList();
        return $this->render('index',['data'=>$data]);
    }
}

?>