<?php

namespace core\repositories\Site;

use core\entities\Site\Glossary\Glossary;
use core\repositories\NotFoundException;

class GlossaryRepository
{
    public function get($id)
    {
        if(!$glossary = Glossary::findOne($id)) {
            throw new NotFoundException('glossary is not found!');
        }

        return $glossary;
    }

    public function save(Glossary $glossary)
    {
        if(!$glossary->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Glossary $glossary)
    {
        if(!$glossary->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }
}