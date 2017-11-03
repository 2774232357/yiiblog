<?php

namespace common\models\base;

use Yii;
use \yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{
    //获取分页数据
    public function getPages($query, $curPage = 1, $sizePage = 30, $search = null)
    {
        if ($search) {
            $query = $query->andFilerWhere($search);
        }
    
        $data['count'] = $query->count();
        if (!$data['count']) {
            return ['count' => 0, 'curPage' => $curPage, 'sizePage' => $sizePage, $start = 0, $end = 0, $data = []];
        }
    
        $curPage = (ceil($data['count'] / $sizePage) < $curPage) ? ceil($data['count'] / $sizePage) : $curPage;
        
        //当前页
        $data['curPage'] = $curPage;
        
        //每页显示条数
        $data['sizePage'] = $sizePage;
        
        //起始页
        $data['start'] = ($curPage - 1) * $sizePage + 1;
        
        //末页
        $data['end'] = (ceil($data['count'] / $sizePage) == $curPage) ? $data['count'] : ($curPage - 1) * $sizePage + $sizePage;
        
        //数据
        $data['data'] = $query->offset(($curPage - 1) * $sizePage)->limit($sizePage)->asArray()->all();
    
        return $data;
    
    }
}
?>