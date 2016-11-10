<?php
/**
 * Created by PhpStorm.
 * User: daixi
 * Date: 2016/11/9
 * Time: 16:14
 */
namespace frontend\controllers;

use common\models\Cats;
use Yii;
use frontend\controllers\base\BaseController;
use frontend\models\PostsForm;

class PostController extends BaseController
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'upload'=>[
                'class' => 'common\widgets\file_upload\UploadAction',     //这里扩展地址别写错
                'config' => [
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ]
        ];
    }
    /**
     * @return string
     */
    public function  actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 创建文章
     * @return string
     */
    public function actionCreate()
    {
        $model = new PostsForm();
        $cat = Cats::getAllCats();
        return $this->render('create',['model'=>$model,'cat'=>$cat]);
    }
}