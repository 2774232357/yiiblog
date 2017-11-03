<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\controllers\base\BaseController;
use frontend\models\PostForm;
use common\models\RelationPostTagModel;
use common\models\PostExtendModel;
use common\models\CategoryModel;

class PostController extends BaseController
{
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'upload', 'ueditor'],
                'rules' => [
                    [
                        'actions' => ['index'],    //登录与否都可以访问
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create', 'upload', 'ueditor'],   //登录以后才能访问
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    '*' => ['get','post'],
//                    'create'=>['get','post']
                ],
            ],
        ];
    }
    
    
    public function actions()
    {
        return [
            'upload'=>[
                'class' => 'common\widgets\file_upload\UploadAction',     //这里扩展地址别写错
                'config' => [
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ],
            
            'ueditor'=>[
                'class' => 'common\widgets\ueditor\UeditorAction',
                'config'=>[
                    //上传图片配置
                    'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ]
            ],
        ];
    }
    
    
    /*
     * 列表
     */
    public function actionIndex ()
    {
        return $this->render('index');
    }
    
    
    public $enableCsrfValidation = false;
    
    /*
     * 新建
     */
    public function actionCreate()
    {
        $model = new PostForm();
        $model->setScenario(PostForm::SCENARIOS_CREATE);
        
        $cats = CategoryModel::getAllCats();
        
        if ($model->load(yii::$app->request->post()) && $model->validate()) {
            if (!$model->create()) {
                yii::$app->session->setFalsh('warning', $model->_lastError);
            }else {
                return $this->redirect(['post/view','id'=>$model->id]);
            }
        }
        
        return $this->render('create',['model'=>$model,'cats' => $cats]);
    }
    
    
    public function actionView($id)
    {
        $model = new PostForm();
        $data = $model->getViewById($id);
        
        $eModel = new PostExtendModel();
        $eModel->upCounter(['post_id'=>$id], 'browser', 1);  // 条件['post_id'=>$id]  字段browser  1数量
        
        return $this->render('view',['data'=>$data]);
    }
}
?>