<?php

namespace core\repositories;

use core\entities\Vacancy\Vacancy;

class VacancyRepoitory
{
    public function get($id)
    {
        if(!$vacancy = Vacancy::findOne($id)) {
            throw new NotFoundException('Vacancy is not found!');
        }

        return $vacancy;
    }

    public function save(Vacancy $vacancy)
    {
        if(!$vacancy->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Vacancy $vacancy)
    {
        if(!$vacancy->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }
}