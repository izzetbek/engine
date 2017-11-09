<?php

namespace core\repositories;

use core\entities\Webinar\Webinar;

class WebinarRepository
{
    public function get($id)
    {
        if(!$webinar = Webinar::findOne($id)) {
            throw new NotFoundException('Webinar is not found!');
        }

        return $webinar;
    }

    public function save(Webinar $webinar)
    {
        if(!$webinar->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Webinar $webinar)
    {
        if(!$webinar->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }
}