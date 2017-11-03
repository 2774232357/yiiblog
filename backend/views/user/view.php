<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = '查看用户' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            //'status',
            [
                'label'=>'状态',
                'value'=>function ($model){
                    return $model->status == 10 ? '激活' : '未激活';
                }
            ],
            //'created_at',
            [
                'attribute'=>'created_at',
                'value'=>date('Y-m-d H:i:s',$model->created_at)
            ],
            //'updated_at',
            [
                'attribute'=>'updated_at',
                'value'=>date('Y-m-d H:i:s',$model->updated_at)
            ],
        ],
    ]) ?>

</div>
