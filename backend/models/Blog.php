<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "blog".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $views
 * @property integer $is_delete
 * @property string $created_at
 * @property string $updated_at
 */
class Blog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'content', 'created_at', 'updated_at'], 'required'],
            [['id', 'views', 'is_delete'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'views' => '点击量',
            'is_delete' => '是否删除 1未删除 2已删除',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
        ];
    }
}
