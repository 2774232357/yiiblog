<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\base\Widget;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'content:ntext',
            'tags:ntext',
            //'status',
            [
                'label'=>'状态',
                'value'=>$model->status0->name
            ],
            //'cache_time:datetime',
            [
                'attribute'=>'cache_time',
                'value'=>date('Y-m-d H:i:s',$model->cache_time)
            ],
            //'update_time',
            [
                'attribute'=>'update_time',
                'value'=>date('Y-m-d H:i:s',$model->update_time)
            ],
            //'author_id',
            [
                'attribute'=>'author_id',
                'value'=>$model->author->username,
                'label'=>'作者'
            ]
        ],
        'template'=>'<tr><th width="120">{label}</th><td>{value}</td></tr>',
        //'options'=>['table table-striped table-bordered detail-view'],
    ]) ?>

</div>
