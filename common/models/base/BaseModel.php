<?php
/**
 * Created by PhpStorm.
 * User: daixi
 * Date: 2016/11/10
 * Time: 9:56
 */
namespace common\models\base;

use yii\db\ActiveRecord;

/**
 * Class BaseModel
 * @package common\models
 */
class BaseModel extends ActiveRecord
{
    /**
     * 获取分页数据
     * @param $query
     * @param int $curPage
     * @param int $pageSize
     * @param null $search
     * @return array
     */
    public function getPages($query,$curPage=1,$pageSize = 10,$search=null)
    {
        if($search){
            $query = $query->andFilerWhere($search);
        }
        $data['count'] = $query->count();
        if(!$data['count']){
            return ['count'=>0,'curPage'=>$curPage,'pageSize'=>$pageSize,'start'=>0,'end'=>0,'data'=>[]];
        }
        //超过实际页数，不取curPage为当前页
        $curPage = (ceil($data['count']/$pageSize)<$curPage)?ceil($data['count']/$pageSize) :$curPage;
        //当前页
        $data['curPage'] = $curPage;
        //每页显示条数
        $data['pageSize'] = $pageSize;

        $data['start'] = ($curPage-1)*$pageSize+1;
        $data['end'] = (ceil($data['count']/$pageSize)==$curPage)
            ?$data['count']:($curPage-1);

       //数据
        $data['data'] = $query->offset(($curPage-1)*$pageSize)->limit($pageSize)->asArray()->all();
        return $data;
    }

}