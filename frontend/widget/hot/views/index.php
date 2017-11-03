<?php
use yii\helpers\Url;
?>

<style>
.hot-list .media-left a{
	box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.1);
    font-size: 12px;
    line-height: 22px;
    background: #5cb85c;
    width: 45px;
    display: block;
    height: 48px;
    text-align: center;
    color: #fff;
    text-decoration: none;
}

.media-left em {
	font-size: 14px;
    font-weight: 500;
    background: #fff;
    display: block;
    line-height: 26px;
	color: #333;
    font-style: normal;
}

.hot-list {
	padding-bottom:10px;
	border-bottom:1px solid #ccc;
	margin-bottom:10px;
}

.media-right {
	line-height:24px;
}

.hot-body {
	padding:10px 0 5px 0;
}

</style>

<?php if(!empty($data)):?>
<div class="panel">
    <div class="panel-title box-title">
        <span><strong><?=$data['title']?></strong></span>
    </div>
    <div class="panel-body hot-body">
        <?php foreach ($data['body'] as $list):?>
        <div class="clearfix hot-list">
            <div class="pull-left media-left">
                <a href="#">浏览<em><?=$list['browser']?></em></a>
            </div>
            <div class="media-right">
                <a href="<?=Url::to(['post/view','id'=>$list['id']])?>"><?=$list['title']?></a>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
<?php endif;?>
