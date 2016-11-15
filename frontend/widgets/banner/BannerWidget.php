<?php
/**
 * Created by PhpStorm.
 * User: daixi
 * Date: 2016/11/15
 * Time: 10:19
 */
namespace frontend\widgets\banner;

use Yii;
use yii\base\Widget;

class BannerWidget extends Widget
{
    public $items = [];

    public function init()
    {
        if(empty($this->items)){
            $this->items = [
                [
                    'label '=>'demo',
                    'image_url'=>'/statics/images/banner/b1.jpg',
                    'url'=>['site/index'],
                    'html'=>'',
                    'active'=>'active',
                ],
                [
                    'label '=>'demo',
                    'image_url'=>'/statics/images/banner/b2.jpg',
                    'url'=>['site/index'],
                    'html'=>'',
                ],
                [
                    'label '=>'demo',
                    'image_url'=>'/statics/images/banner/b3.jpg',
                    'url'=>['site/index'],
                    'html'=>'',
                ],
            ];
        }

    }

    /**
     * @return string
     */
    public function run()
    {
        $data['items'] = $this->items;
        return $this->render('index',['data'=>$data]);
    }
}