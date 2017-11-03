<?php
use yii\bootstrap\Carousel;

?>
<div class="panel">
    <?= Carousel::widget([
        'items' => $data['items']/* [
            // 与上面的效果一致,包含图片和字幕的格式
            ['content' => '<img src=' . Yii::$app->request->baseUrl . '/statics/images/banner/b1.jpg>'],
            ['content' => '<img src=' . Yii::$app->request->baseUrl . '/statics/images/banner/b2.jpg>',],
            ['content' => '<img src=' . Yii::$app->request->baseUrl . '/statics/images/banner/b3.jpg>',],
        ] */
    ]);
    ?>
</div>
