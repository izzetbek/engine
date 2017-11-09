<?php

namespace core\repositories\Site;

use core\entities\Site\Gallery\Gallery;
use core\repositories\NotFoundException;

class GalleryRepository
{
    public function get($id)
    {
        if(!$brand = Gallery::findOne($id)) {
            throw new NotFoundException('Brand is not found!');
        }

        return $brand;
    }

    public function save(Gallery $brand)
    {
        if(!$brand->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Gallery $brand)
    {
        if(!$brand->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }
}