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

use common\models\Posts;
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
    /**
     * 定义场景
     */
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     *定义事件
     */
    const EVENT_AFTER_CREATE = 'evebtAfterCreate';
    const EVENT_AFTER_UPDATE = 'evebtAfterUpdate';
    /**
     * 场景设置
     * @return array
     */
    public function scenarios()
    {
        $scenarios = [
            self::SCENARIO_CREATE=>['title','content','label_img','cat_id','tags','create_at','update_at'],
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
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $model = new Posts();
            $model->setAttributes($this->attributes);
            $model->summary = $this->_getSummary();
            $model->user_id = Yii::$app->user->identity->id;
            $model->user_name = Yii::$app->user->identity->username;
            $model->is_valid = Posts::IS_VALID;
            $model->created_at = time();
            $model->updated_at = time();
            if(!$model->save())
                throw new \Exception('文章保存失败');

            $this->id=$model->id;

            //调用事件
            $data = array_merge($this->getAttributes(),$model->getAttributes());
           $this->_eventAfterCreate($data);

            $transaction->commit();
            return true;
        }catch(\Exception $e){
            $transaction->rollBack();
            $this->_lastError = $e->getMessage();

        }

    }

    /**
     * 截取文章摘要
     * @param int $s
     * @param int $e
     * @param string $char
     * @return null
     */
    private function _getSummary($s = 0,$e = 90,$char = 'utf-8')
    {
        if(empty($this->content))
            return null;

        return (mb_substr(str_replace('&nbsp;','',strip_tags($this->content)),$s,$e,$char));
    }


    /**
     * 创建完成后调用
     * @param $data
     */
    public function _eventAfterCreate($data)
    {
        $this->on(self::EVENT_AFTER_CREATE,[$this,'_eventAddTag'],$data);
//        $this->on(self::EVENT_AFTER_UPDATE,[$this,'_eventAddOne'],$data);
        //触发事件
        $this->trigger(self::EVENT_AFTER_CREATE);
    }

    /**
     * 添加标签
     */
    public function _eventAddTag()
    {

    }
}