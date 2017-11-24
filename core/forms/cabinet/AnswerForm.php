<?php

namespace core\forms\cabinet;

use core\entities\Cabinet\Answer;
use yii\base\Model;

class AnswerForm extends Model
{
    public $content;

    private $_answer;

    public function __construct(Answer $answer = null, array $config = [])
    {
        if ($answer) {
            $this->content = $answer->content;
            $this->_answer = $answer;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['content', 'required'],
        ];
    }
}