<?php

namespace core\repositories\Site;

use core\entities\Site\Partner;
use core\repositories\NotFoundException;

class PartnerRepository
{
    public function get($id)
    {
        if(!$partner = Partner::findOne($id)) {
            throw new NotFoundException('partner is not found.');
        }
        return $partner;
    }

    public function save(Partner $partner)
    {
        if(!$partner->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Partner $partner)
    {
        if(!$partner->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }
}