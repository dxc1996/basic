<?php
/**
 * Created by PhpStorm.
 * User: daixi
 * Date: 2016/11/14
 * Time: 9:22
 */
namespace frontend\models;

use yii\base\Model;
use common\models\Tags;

/**
 * 标签的表单模型
 */
class TagForm  extends Model
{
    public $id;
    public $tags;

    public function rules()
    {
        return [
            ['tags','required'],
            ['tags','each','rule'=>['string']],
        ];
    }

    public function saveTags()
    {
        $ids = [];
        if(!empty($this->tags)){
            foreach($this->tags as $tag){
                $ids[]=$this->_saveTag($tag);
            }
        }
        return $ids;
    }

    /**
     * 保存标签
     * @param $tag
     * @return array|null|\yii\db\ActiveRecord
     * @throws \Exception
     */
    private function _saveTag($tag)
    {
        $model = new Tags();
        $res = $model->find()->where(['tag_name'=>$tag])->one();
        //新建
        if(!$res){
            $model->tag_name = $tag;
            $model->post_num = 1;
            if(!$model->save()){
                throw new \Exception('保存失败');
            }
            return $model->id;
        }else{
            $res->updateCounters(['post_num'=>1]);
        }
        return $res->id;
    }
}