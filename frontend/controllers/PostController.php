<?php
/**
 * Created by PhpStorm.
 * User: daixi
 * Date: 2016/11/9
 * Time: 16:14
 */
namespace frontend\controllers;

use Yii;
use frontend\controllers\base\BaseController;

class PostController extends BaseController
{
    public function  actionIndex()
    {
        return $this->render('index');
    }
}