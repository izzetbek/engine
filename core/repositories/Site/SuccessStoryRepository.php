<?php

namespace core\repositories\Site;

use core\repositories\NotFoundException;
use core\entities\Site\SuccessStory\SuccessStory;

class SuccessStoryRepository
{
    public function get($id)
    {
        if (!$story = SuccessStory::findOne($id)) {
            throw new NotFoundException('story is not found!');
        }

        return $story;
    }

    public function save(SuccessStory $story)
    {
        if (!$story->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(SuccessStory $story)
    {
        if (!$story->delete()) {
            throw new \RuntimeException('Deleting error.');
        }

    }
}