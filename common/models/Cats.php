<?php

namespace common\models;

use common\models\base\BaseModel;
use Yii;

/**
 * This is the model class for table "cats".
 *
 * @property integer $id
 * @property string $cat_name
 */
class Cats extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cats';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_name' => 'Cat Name',
        ];
    }

    /**
     * 获取所有分类
     * @return array
     */
    public static function getAllCats()
    {
        $cat = ['0'=>'暂无分类'];
        $res = self::find()->asArray()->all();
        if($res){
            foreach($res as $key => $list)
            {
                $cat[$list['id']]=$list['cat_name'];
            }
        }
        return $cat;
    }
    /**
     * @inheritdoc
     * @return PostsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostsQuery(get_called_class());
    }
}
