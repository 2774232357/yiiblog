<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Poststatus;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新增文章', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            [
                'attribute'=>'id',
                'contentOptions'=>['width'=>'30px']
            ],
            //'title',
            [
                'attribute'=>'title',
                'format'=>'raw',
                'value'=>function($model){
                    return '<a href="' . Yii::$app->params['frontDomain'] . Url::to(['post/view','id'=>$model->id]) . '">'.$model->title.'</a>';
                },
            ],
//            'author_id',
            [
                'attribute'=>'authorName',
                'value'=>'author.nickname',
                'label'=>'作者'
            ],
//            'content:ntext',
            'tags:ntext',
//            'status',
            [
                'attribute'=>'status',
                'value'=>'status0.name',
                'filter'=>Poststatus::find()
                                    ->select('name,id')
                                    ->orderBy('position')
                                    ->indexBy('id')
                                    ->column()
            ],
            // 'cache_time',
//             'update_time',
            [
                'attribute'=>'update_time',
                'format'=>['date','php:Y-m-d H:i:s']
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
