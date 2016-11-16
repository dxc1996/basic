<?php
/**
 * Created by PhpStorm.
 * User: daixi
 * Date: 2016/11/16
 * Time: 10:16
 */
namespace frontend\widgets\chat;
/**
 * 留言板组件
 */
use frontend\models\FeedsForm;
use Yii;
use yii\bootstrap\Widget;
use yii\base\Object;

class ChatWidget extends Widget
{
    public function run()
    {
        $feed = new FeedsForm();
        $data['feeds'] = $feed->getList();
        return $this->render('index',['data'=>$data]);
    }
}