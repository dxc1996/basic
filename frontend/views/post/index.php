<?php
/**
 * Created by PhpStorm.
 * User: daixi
 * Date: 2016/11/10
 * Time: 13:24
 */
use frontend\widgets\post\PostWidget;
use yii\base\Widget;
?>
<div class="row">
    <div class="col-lg-9">
        <?=PostWidget::widget(['limit'=>1]) ?>
    </div>
    <div class="col-lg-3">

    </div>
</div>