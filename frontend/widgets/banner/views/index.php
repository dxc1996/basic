<?php
use yii\helpers\Url;

?>
<div class="panel">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php foreach ($data['items'] as $k=>$list): ?>
            <li data-target="#carousel-example-generic" data-slide-to="<?=$k?>" class="<?=(isset($list['active']) && $list['active'])?'active':''  ?>"></li>
            <?php endforeach; ?>
        </ol>
        <div class="carousel-inner home-banner" role="listbox">
            <?php foreach ($data['items'] as $k=>$list):?>
            <div class="item <?=(isset($list['active']) && $list['active'])?'active':''  ?>">
                <a href="<?=Url::to($list['url'])?>"><img src="<?=$list['image_url']?>" alt="">
                <div class="carousel-caption">
                    <?=$list['html']?>
                </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>