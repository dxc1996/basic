<?php
/**
 * Created by PhpStorm.
 * User: daixi
 * Date: 2016/11/9
 * Time: 16:09
 */
namespace  frontend\controllers\base;

use yii\web\Controller;

class BaseController extends Controller
{
    public  function beforeAction($action)
    {
        if(!parent::beforeAction($action)){
            return false;
        }
        return true;
    }
}