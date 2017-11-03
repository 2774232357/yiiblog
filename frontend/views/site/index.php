<?php

use frontend\widget\banner\BannerWidget;
use yii\base\Widget;
use frontend\widget\chat\ChatWidget;
use frontend\widget\hot\HotWidget;
use frontend\widget\tag\TagWidget;
use frontend\widget\post\PostWidget;

$this->title = '博客-首页';
?>
<div class="row">
    <div class="col-lg-9">
        <?=BannerWidget::widget() ?>
        <?= PostWidget::widget(['title' => '文章列表','page' => true,'limit'=>8]) ?>
    </div>
    <div class="col-lg-3">
        <?=ChatWidget::widget() ?>
        <?=HotWidget::widget() ?>
        <?=TagWidget::widget() ?>
    </div>
</div>
