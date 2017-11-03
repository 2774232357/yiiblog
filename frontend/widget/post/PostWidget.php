<?php
namespace frontend\widget\post;

use common\models\PostModel;
use frontend\models\PostForm;
use yii\base\Widget;
use Yii;
use yii\data\Pagination;
use yii\helpers\Url;

class PostWidget extends Widget
{
    public $title = '';

    //显示条娄
    public $limit = 6;

    //是否显示更多
    public $more = true;

    //是否显示分页
    public $page = true;

    public $con = [];

    public function run()
    {
        $curPage = Yii::$app->request->get('page', 1);
        //查询条件
        $cond = ['=', 'is_valid', PostModel::IS_VALID];
        $con = $this->con?:[];
        $res = PostForm::getList($con,$cond, $curPage, $this->limit);
        $result['title'] = $this->title ?: '最新文章';
        $result['more'] = Url::to(['post/index']);
        $result['body'] = $res['data'] ?: [];

        //是否显示分页
        if ($this->page) {
            $pages = new Pagination(['totalCount' => $res['count'],'pageSize' => $res['sizePage']]);
            $result['page'] = $pages;

        }
        return $this->render('index',[
            'data' => $result,
        ]);
    }



}

?>