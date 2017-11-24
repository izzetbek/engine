<?php

namespace core\repositories\Cabinet;

use core\repositories\NotFoundException;
use core\entities\Cabinet\Question;

class QuestionRepository
{
    public function get($id)
    {
        if(!$question = Question::findOne($id)) {
            throw new NotFoundException('Question is not found.');
        }
        return $question;
    }

    public function save(Question $question)
    {
        if(!$question->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Question $question)
    {
        if(!$question->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }
}