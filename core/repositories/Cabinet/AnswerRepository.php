<?php

namespace core\repositories\Cabinet;

use core\repositories\NotFoundException;
use core\entities\Cabinet\Answer;

class AnswerRepository
{
    public function get($id)
    {
        if(!$answer = Answer::findOne($id)) {
            throw new NotFoundException('Answer is not found.');
        }
        return $answer;
    }

    public function save(Answer $answer)
    {
        if(!$answer->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Answer $answer)
    {
        if(!$answer->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }
}