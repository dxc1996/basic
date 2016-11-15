<?php
/**
 * Created by PhpStorm.
 * User: daixi
 * Date: 2016/11/14
 * Time: 15:28
 */
namespace frontend\widgets\post;
/**
 * 文章列表组件
 */
use common\models\Posts;
use frontend\models\PostsForm;
use Yii;
use yii\base\Widget;
use yii\data\Pagination;
use yii\helpers\Url;

class PostWidget extends Widget
{
    /**
     * 文章列表的标题
     * @var string
     */
    public $title = '';
    /**
     * 显示条数
     * @var int
     */
    public $limit = 5;
    /**
     * 是否显示更多
     * @var bool
     */
    public $more = true;
    /**
     * 是否显示分页
     * @var bool
     */
    public $page = true;

    /**
     * @return string
     */
    public function run()
    {
        $curPage = Yii::$app->request->get('page',1);
        //查询条件
        $cond = ['=','is_valid',Posts::IS_VALID];
        $res = PostsForm::getList($cond,$curPage,$this->limit);
        $result['title'] = $this->title ? $this->title : "最新文章";
        $result['more'] =Url::to(['post/index']);
        $result['body'] = $res['data'] ? $res['data'] :[];
        if($this->page){
            $pages = new Pagination(['totalCount'=>$res['count'],'pageSize'=>$res['pageSize']]);
            $result['page'] = $pages;
        }

        return $this->render('index',['data'=>$result]);
    }
}