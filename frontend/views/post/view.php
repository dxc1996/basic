<?php
/**
 * Created by PhpStorm.
 * User: daixi
 * Date: 2016/11/14
 * Time: 14:07
 */
$this->title = $data['title'];
$this->params['breadcrumbs'][]=['label'=>'文章','url'=>['post/index']];
$this->params['breadcrumbs'][]=$this->title;
?>

<div class="row">
        <div class="col-lg-9">
            <h1><?=$data['title']?></h1>
            <span>作者:<?=$data['user_name'] ?></span>
            <span>发布:<?=date('Y-m-d',$data['created_at']); ?></span>
            <span>浏览:<?=isset($data['extend']['browser'])?$data['extend']['browser']:0 ?>次</span>
        </div>
    <div class="page-content" style="">
        <?=$data['content'] ?>
    </div>

    <div class="page-tag">
        标签:
            <?php foreach($data['tags'] as $tag): ?>
                <span><a href="#" ><?= $tag?></a></span>
        <?php endforeach;?>
    </div>
</div>