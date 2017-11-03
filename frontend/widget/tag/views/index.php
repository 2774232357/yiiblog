<?php
use yii\helpers\Url;
?>

<style>
.tag-cloud a {
	border: 1px solid #ebebeb;
    padding: 2px 7px;
    color: #333;
    line-height: 2em;
    display: inline-block;
	font-size:14px;
    margin: 0 7px 7px 0;
    transition: all 0.2s ease;
}

.tag-cloud a:hover {
	background-color:#5bc0de;
	text-decoration: none;
}
</style>

<div class="panel-title box-title">
    <span><strong><?=$data['title']?></strong></span>
    </div>
<div class="panel-body padding-left-0">
    <div class="tag-cloud">
        <?php foreach ($data['body'] as $list):?>
		<a href="<?=Url::to(['post/index','tag'=>$list['tag_name']])?>"><?=$list['tag_name']?></a>
		<?php endforeach;?>
    </div>
</div>