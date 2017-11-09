<?php

namespace backend\forms;

use yii\base\Model;

class WebinarsSalesSearch extends Model
{
    public $user;
    public $name;

    public function rules()
    {
        return [
            [['user', 'name', 'type'], 'safe']
        ];
    }

    public function search($params)
    {

    }
}