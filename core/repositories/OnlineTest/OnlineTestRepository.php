<?php

namespace core\repositories\OnlineTest;

use core\entities\OnlineTest\Test\OnlineTest;
use core\repositories\NotFoundException;

class OnlineTestRepository
{
    public function get($id)
    {
        if(!$onlineTest = OnlineTest::findOne($id)) {
            throw new NotFoundException('Test is not found!');
        }

        return $onlineTest;
    }

    public function save(OnlineTest $onlineTest)
    {
        if(!$onlineTest->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(OnlineTest $onlineTest)
    {
        if(!$onlineTest->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }
}