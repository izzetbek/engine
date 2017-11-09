<?php

namespace core\repositories\Site;

use core\repositories\NotFoundException;
use core\entities\Site\Banner;

class BannerRepository
{
    public function get($id)
    {
        if(!$banner = Banner::findOne($id)) {
            throw new NotFoundException('Banner is not found.');
        }
        return $banner;
    }

    public function save(Banner $banner)
    {
        if(!$banner->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Banner $banner)
    {
        if(!$banner->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }
}