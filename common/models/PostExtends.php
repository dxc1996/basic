<?php

namespace common\models;

use common\models\base\BaseModel;
use Yii;

/**
 * This is the model class for table "post_extends".
 *
 * @property integer $id
 * @property integer $post_id
 * @property integer $browser
 * @property integer $collect
 * @property integer $praise
 * @property integer $comment
 */
class PostExtends extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_extends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'browser', 'collect', 'praise', 'comment'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增ID',
            'post_id' => '文章id',
            'browser' => '浏览量',
            'collect' => '收藏量',
            'praise' => '点赞',
            'comment' => '评论',
        ];
    }

    /**
     * 更新文章统计
     * @param $cond
     * @param $attibute
     * @param $num
     */
    public function upCounter($cond,$attibute,$num)
    {
        //var_dump($cond['post_id']);die;
        $counter = $this->findOne($cond);
        if(!$counter){
            $this->setAttributes($cond);
            $this->$attibute =$num;
            $this->save();
        }else{
            $countData[$attibute] = $num;
            $counter->updateCounters($countData);
        }
    }
}
