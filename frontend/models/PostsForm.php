<?php
/**
 * Created by PhpStorm.
 * User: daixi
 * Date: 2016/11/10
 * Time: 10:09
 */
/**
 * 文章表单模型
 */
namespace frontend\models;

use Yii;
use yii\base\Model;

class PostsForm extends Model
{
    public $id;
    public $title;
    public $content;
    public $label_img;
    public $cat_id;
    public $tags;

    public $_lastError = '';

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * 场景设置
     * @return array
     */
    public function scenarios()
    {
        $scenarios = [
            self::SCENARIO_CREATE=>['title','content','label_img','cat_id','tags'],
            self::SCENARIO_UPDATE=>['title','content','label_img','cat_id','tags'],
        ];
        return array_merge(parent::scenarios(),$scenarios);
    }
    public function rules()
    {
        return [
            [['id','title','content','cat_id'],'required'],
            [['id','cat_id'],'integer'],
            ['title','string','min'=>4,'max'=>50],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id'=>'编码',
            'title'=>'标题',
            'content'=>'内容',
            'labl_img'=>'标签图',
            'tags'=>'标签',
            'cat_id'=>'分类',
        ];
    }

    /**
     * @param $behaviors
     */
    public function setBehaviors($behaviors)
    {
        $this->behaviors = $behaviors;
    }

    public function create()
    {
        //事务
        $transaction = \Yii::$app->db->beginTransaction();
        try{

            $transaction->commit();
            return true;
        }catch(\Exception $e){
            $transaction->rollBack();
            $this->_lastError = $e->getMessage();

        }

    }
}