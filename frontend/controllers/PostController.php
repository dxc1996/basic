<?php
/**
 * Created by PhpStorm.
 * User: daixi
 * Date: 2016/11/9
 * Time: 16:14
 */
namespace frontend\controllers;

use common\models\Cats;
use common\models\PostExtends;
use Yii;
use frontend\controllers\base\BaseController;
use frontend\models\PostsForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class PostController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create','upload','ueditor'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create','upload','ueditor'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    '*' =>['get','post'],

                ],
            ],
        ];
    }
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
     * 文章列表
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

        if($model->load(Yii::$app->request->post()) && $model->validate()){
            if(!$model->create()){
                Yii::$app->session->setFlash('warning',$model->_lastError);
            }else{
                return $this->redirect(['post/view','id'=>$model->id]);
            }
        }
        $cat = Cats::getAllCats();
        return $this->render('create',['model'=>$model,'cat'=>$cat]);
    }

    /**
     * 文章详情
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = new PostsForm();
        $data = $model->getViewById($id);
        //文章统计
        $model = new PostExtends();
        $model->upCounter(['post_id'=>$id],'browser',1);
        return $this->render('view',['data'=>$data]);
    }
}