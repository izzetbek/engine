<?php

namespace core\services\manager\Site;

use core\entities\Site\Document\Document;
use core\forms\manager\Site\Document\DocumentForm;
use core\repositories\Site\DocumentRepository;
use core\services\manager\ManagerService;

class DocumentManageService extends ManagerService
{
    public function __construct(DocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(DocumentForm $form)
    {
        if ($form->textFile) {
            $form->file = self::saveFile($form->textFile, 'documents');
        }
        $document = Document::create($form->file, $form->order, $form->draft);
        foreach ($form->translations as $translation) {
            $document->addTranslation(
                $translation->language,
                $translation->title
            );
        }
        $this->repository->save($document);
        return $document->id;
    }

    public function edit($id, DocumentForm $form)
    {
        $document = $this->repository->get($id);
        /** $@var Document $document */
        if ($form->textFile) {
            if ($form->file) {
                self::saveFile($form->textFile, 'documents', $form->file);
            } else {
                $form->file = self::saveFile($form->textFile, 'documents');
            }
        }
        $document->edit($form->file, $form->order, $form->draft);
        $document->revokeTranslations();
        foreach ($form->translations as $translation) {
            $document->addTranslation(
                $translation->language,
                $translation->title
            );
        }
        $this->repository->save($document);
    }

    public function deleteThumb($id)
    {
        $document = $this->repository->get($id);
        /** $@var Document $document */
        if (!$document->file) {
            throw new \DomainException('File doesn`t exist');
        }
        unlink(\Yii::getAlias('@frontend/web/upload/documents/' . $document->file));
        $document->file = null;
        $this->repository->save($document);
    }
}