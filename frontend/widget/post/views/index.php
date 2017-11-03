<?php
use yii\widgets\LinkPager;
?>
<style>
    .post-label > img {
        margin-left: auto;
        margin-right: auto;
        display: block;
        height: 150px;
        width: 100%;
    }
    img {
        vertical-align: middle;
    }
    img {
        border: 0;
    }
    .container a {
        text-decoration: none;
        outline: none;
        cursor: pointer;
    }
    .post-label {
        background-color: #fff;
        border: 1px solid #ddd;
        display: block;
        line-height: 1.42857;
        padding: 4px;
        transition: border 0.2s ease-in-out 0s;
    }
    .post-label {
        border-radius: 0;
        margin-bottom: 5px;
        position: relative;
    }
    .panel-body h1 {
        font-size: 18px;
        height: 30px;
        line-height: 30px;
        margin: 0;
        overflow: hidden;
    }
    .cat {
        color: #999;
        font-size: 14px;
    }
    .top {
        font-size: 12px;
        background: #5bc0de none repeat scroll 0 0;
        border: 1px solid #5bc0de;
        color: #fff;
        margin-left: 4px;
        padding: 2px 7px;
    }
    .post-tags {
        color: #999;
        font-size: 12px;
    }
    .post-tags a {
        color: #999;
    }
    p {
        margin: 0 0 10px;
    }
    p {
        display: block;
        -webkit-margin-before: 1em;
        -webkit-margin-after: 1em;
        -webkit-margin-start: 0px;
        -webkit-margin-end: 0px;
    }
    html, body {
        height: 100%;
        font-family: '微软雅黑',"Helvetica Neue",Helvetica,Arial,"Hiragino Sans GB","Microsoft Yahei",sans-serif;
        background: #fff;
    }
    .tags {
        font-size: 12px;
        margin-left: 2px;
    }
    .font-12 {
        font-size: 12px;
    }
</style>
<div class="panel">
    <div class="panel-title box-title">
        <span><?= $data['title']?></span>
        <span class="pull-right"><a href="<?=$data['more']?>" class="font-12">更多»</a></span>
    </div>
    <div class="new-list">
        <?php foreach($data['body'] as $result):?>
        <div class="panel-body border-bottom">
            <div class="row">

                <div class="col-lg-4 label-img-size">
                    <a href="#" class="post-label">
                        <img src="<?php echo $result['label_img']?>" alt="Yii2.0 基于RBAC的后台管理系统（附演示地址）">
                    </a>
                </div>
                <div class="col-lg-8 btn-group">
                    <h1><a href="<?=\yii\helpers\Url::to(['post/view','id' => $result['id']])?>"><?= $result['title']?></a>&nbsp;<span class="cat">[基础教程]</span><span class="top">置顶</span></h1>
                    <span class="post-tags">
                        <span class="glyphicon glyphicon-user"></span>&nbsp;<a href="#"><?= $result['user_name']?></a>&nbsp;
                        <span class="glyphicon glyphicon-time"></span>&nbsp;<?= date('Y-m-d H:i:s',$result['created_at'])?>&nbsp;
                        <span class="glyphicon glyphicon-eye-open"></span>&nbsp;<?= isset($result['extend'])?$result['extend']['browser']:0?>
                        <span class="glyphicon glyphicon-comment"></span>&nbsp;<a href="#"><?= isset($result['commit'])?$result['commit']:0?></a>
                    </span>
                    <p class="post-content"><?= $result['summary']?></p>
                    <a href="<?=\yii\helpers\Url::to(['post/view','id' => $result['id']])?>"><button class="btn btn-warning no-radius btn-sm pull-right">阅读全文</button></a>
                </div>
            </div>
            <div class="tags">
                <span class="fa fa-tags"></span>
                <?php foreach($result['tags'] as $tag):?>
                <a href="#"><?= $tag?></a>，
                <?php endforeach;?>
            </div>
        </div>
        <?php endforeach;?>
        <?php if($data['page']){?>
        <div class="page">
            <?=LinkPager::widget(['pagination' => $data['page']]);?>
        </div>
        <?php }?>
    </div>
</div>
