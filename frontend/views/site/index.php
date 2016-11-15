<?php
use frontend\widgets\banner\BannerWidget;
use yii\base\Widget;
use frontend\widgets\chat\ChatWidget;

$this->title = '博客-首页';
?>

<div class="row">
    <div class="col-lg-9">
        <?=BannerWidget::widget([])?>
    </div>
    <div class="col-lg-3">
        safjkahdjkahjhfjsh
    </div>
    <div class="row">
            <div class="col-lg-9">
                <?=\frontend\widgets\post\PostWidget::widget();?>
            </div>
    </div>
</div>