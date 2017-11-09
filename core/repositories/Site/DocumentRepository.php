<?php

namespace core\repositories\Site;

use core\repositories\NotFoundException;
use core\entities\Site\Document\Document;

class DocumentRepository
{
    public function get($id)
    {
        if(!$document = Document::findOne($id)) {
            throw new NotFoundException('document is not found!');
        }

        return $document;
    }

    public function save(Document $document)
    {
        if(!$document->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Document $document)
    {
        if(!$document->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }
}