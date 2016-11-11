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
            ],
            'ueditor'=>[
                 'class' => 'common\widgets\ueditor\UeditorAction',
                'config'=>[
                //上传图片配置
                'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ]
             ],
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
        //定义场景
        $model->setScenario(PostsForm::SCENARIO_CREATE);
        $cat = Cats::getAllCats();
        return $this->render('create',['model'=>$model,'cat'=>$cat]);
    }
}