<?php
namespace core\repositories\Site;

use core\entities\Site\Tag;
use core\repositories\NotFoundException;

class TagRepository
{
    public function get($id)
    {
        if(!$tag = Tag::findOne($id)) {
            throw new NotFoundException('Tag is not found.');
        }
        return $tag;
    }

    public function save(\core\entities\Site\Tag $tag)
    {
        if(!$tag->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Tag $tag)
    {
        if(!$tag->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }
}