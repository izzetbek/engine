<?php

namespace core\repositories;

use core\entities\Training\Training;

class TrainingRepository
{
    public function get($id)
    {
        if(!$training = Training::findOne($id)) {
            throw new NotFoundException('training is not found!');
        }

        return $training;
    }

    public function save(Training $training)
    {
        if(!$training->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Training $training)
    {
        if(!$training->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }
}