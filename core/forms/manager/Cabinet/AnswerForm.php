<?php

namespace core\forms\manager\Cabinet;

use yii\base\Model;

class AnswerForm extends Model
{
    public $answer;

    public function rules()
    {
        return [
            ['answer', 'required']
        ];
    }
}