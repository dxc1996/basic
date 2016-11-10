<?php
/**
 * Created by PhpStorm.
 * User: daixi
 * Date: 2016/11/10
 * Time: 13:25
 */
use frontend\controllers\PostController;
$this->title='创建';
$this->params['breadcrumbs'][]=['label'=>'文章','url'=>['post/index']];
$this->params['breadcrumbs'][]=$this->title;
?>
<div class="row">
    <div class="col-lg-9">
        <div class="panel-title box-title">
            <span>创建文章</span>
        </div>
        <div class="panel-body">
            <?php $form = \yii\bootstrap\ActiveForm::begin();?>
            <?=$form->field($model,'title')->textInput(['maxlength'=>true])?>


            <?=$form->field($model,'cat_id')->dropDownList($cat)?>



            <?= $form->field($model, 'label_img')->widget('common\widgets\file_upload\FileUpload',[
                'config'=>[
                    //图片上传的一些配置，不写调用默认配置
                    //'domain_url' => 'http://www.yii-china.com',
                ]
            ]) ?>


            <?= $form->field($model, 'content')->widget('common\widgets\ueditor\Ueditor',[
                'options'=>[
                    'initialFrameWidth' => 400,
                   /* 'toolbars'=>[],*/

                ]
            ]) ?>
            <?=$form->field($model,'tags')->textInput(['maxlength'=>true])?>

            <div class="form-group">
                <?=\yii\bootstrap\Html::submitButton('发布',['class'=>'btn btn-success'])?>
            </div>
        <?php \yii\bootstrap\ActiveForm::end()?>
        </div>
    <div>
    <div class="col-lg-3"></div>
</div>
