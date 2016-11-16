<?php
/**
 * Created by PhpStorm.
 * User: daixi
 * Date: 2016/11/16
 * Time: 10:09
 */
namespace frontend\models;

use common\models\Feeds;
use yii\base\Model;
class FeedsForm extends Model
{
    public $content;
    public $_lastError;

    public function rules()
    {
        return [
            ['content','required'],
            ['content','string','max'=>255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'=>'ID',
            'content'=>'内容'
        ];
    }

    public function getList()
    {
        $model = new Feeds();
        $res = $model->find()->limit(10)->with('user')->orderBy(['id'=>SORT_DESC])->asArray()->all();
        return $res?$res:[];
    }
}