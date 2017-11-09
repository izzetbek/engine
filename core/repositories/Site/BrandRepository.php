<?php

namespace core\repositories\Site;

use core\entities\Site\Brand;
use core\repositories\NotFoundException;

class BrandRepository
{
    public function get($id)
    {
        if(!$brand = Brand::findOne($id)) {
            throw new NotFoundException('Brand is not found!');
        }

        return $brand;
    }

    public function save(Brand $brand)
    {
        if(!$brand->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Brand $brand)
    {
        if(!$brand->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }
}