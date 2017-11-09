<?php

namespace core\repositories\OnlineTest;

use core\entities\OnlineTest\Question\Question;
use core\repositories\NotFoundException;

class QuestionRepository
{
    public function get($id)
    {
        if(!$question = Question::findOne($id)) {
            throw new NotFoundException('Question is not found!');
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