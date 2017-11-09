<?php

namespace core\repositories\Site;

use core\entities\Site\Team\Team;
use core\repositories\NotFoundException;

class TeamRepository
{
    public function get($id)
    {
        if(!$teammate = Team::findOne($id)) {
            throw new NotFoundException('Teammate is not found.');
        }
        return $teammate;
    }

    public function save(Team $teammate)
    {
        if(!$teammate->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Team $teammate)
    {
        if(!$teammate->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }
}