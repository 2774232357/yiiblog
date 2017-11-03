<?php

use frontend\widget\post\PostWidget;
use frontend\widget\banner\BannerWidget;
use frontend\widget\chat\ChatWidget;
use frontend\widget\hot\HotWidget;
use frontend\widget\tag\TagWidget;

$this->title = '文章列表';

$this->params['breadcrumbs'][]=['label' =>'文章','url'=>['post/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-9">
        <?= PostWidget::widget(['title' => '文章列表','page' => true,'limit'=>8]) ?>
    </div>
    <div class="col-lg-3">
        <?=ChatWidget::widget() ?>
        <?=HotWidget::widget() ?>
        <?=TagWidget::widget() ?>
    </div>
</div>
