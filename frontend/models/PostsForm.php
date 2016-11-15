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
use common\models\RelationPostTags;
use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\web\NotFoundHttpException;

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
//        $this->on(self::EVENT_AFTER_UPDAT-E,[$this,'_eventAddOne'],$data);
        //触发事件
        $this->trigger(self::EVENT_AFTER_CREATE);
    }

    /**
     * 添加标签
     */
    public function _eventAddTag($event)
    {
        $tag = new TagForm();
        $tag->tags = $event->data['tags'];
        $tagids = $tag->saveTags();
        //删除原先的关联关系
        RelationPostTags::deleteAll(['post_id'=>$event->data['id']]);
        //批量保存文章和标签的关联关系
        if(!empty($tagids)){
            foreach ($tagids as $k => $id){
                $row[$k]['post_id'] = $this->id;
                $row[$k]['tag_id'] = $id;
            }

            $res=(new Query())->createCommand()->batchInsert(RelationPostTags::tableName(),['post_id','tag_id'],$row)
                ->execute();

            if(!$res)
                throw new \Exception('保存失败');
        }
    }

    /**
     * 获取文章
     * @param $id
     * @throws NotFoundHttpException
     */
    public function getViewById($id)
    {
        $res = Posts::find()->with('relate.tag','extend')->where(['id'=>$id])->asArray()->one();
        if(!$res){
            throw new NotFoundHttpException('文章不存在');
        }
        $res['tags'] = [];
        if(isset($res['relate'])&& !empty($res['relate']))
        {
            foreach($res['relate'] as $list){
                $res['tags'][] = $list['tag']['tag_name'];
            }
        }
        unset($res['relate']);
        return $res;
    }

    public static function getList($cond,$curPage=1,$pageSize = 5,$orderBy=['id'=>SORT_DESC])
    {
        $model= new Posts();
        //查询语句
        $select = ['id','title','summary','label_img','cat_id','user_id','user_name',
            'is_valid','created_at'];
        $query = $model->find()->select($select)->where($cond)->with('relate.tag','extend')
            ->orderBy($orderBy);

        //获取分页数据
        $res = $model->getPages($query,$curPage,$pageSize);
        //格式化
        $res['data'] = self::_formatList($res['data']);
        return $res;
    }

    /**
     * 数据格式化
     * @param $data
     * @return mixed
     */
    public static function _formatList($data)
    {
        foreach($data as &$list){
            $list['tags'] = [];
            if(isset($list['relate']) && !empty($list['relate'])){
                foreach($list['relate'] as $lt){
                    $list['tags'][] = $lt['tag']['tag_name'];
                }
            }
            unset($list['relate']);
        }
        return $data;
    }
}