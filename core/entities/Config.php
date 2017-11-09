<?php

namespace core\entities;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{config}}".
 *
 * The followings are the available columns in table '{{config}}':
 *
 * @property string $id
 * @property string $param
 * @property string $value
 * @property string $default
 * @property string $label
 * @property string $type
 */
class Config extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%config}}';
    }

    public function rules()
    {
        return [
            ['param', 'required'],
            ['value', 'safe'],
            ['id, param, value, label, type, default', 'safe', 'on' => 'search'],
        ];
    }
}