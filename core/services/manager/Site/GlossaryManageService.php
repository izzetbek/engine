<?php

namespace core\services\manager\Site;


use core\entities\Site\Glossary\Glossary;
use core\forms\manager\Site\Glossary\GlossaryForm;
use core\repositories\Site\GlossaryRepository;

class GlossaryManageService
{
    private $repository;

    public function __construct(GlossaryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(GlossaryForm $form)
    {
        $glossary = Glossary::create($form->draft);

        foreach ($form->translations as $translation) {
            $glossary->addTranslation($translation->language, $translation->title, $translation->description);
        }

        $this->repository->save($glossary);
        return $glossary->id;
    }

    public function edit($id, GlossaryForm $form)
    {
        $glossary = $this->repository->get($id);
        /** @var Glossary $glossary */
        $glossary->edit($form->draft);

        $glossary->revokeTranslations();
        foreach ($form->translations as $translation) {
            $glossary->addTranslation($translation->language, $translation->title, $translation->description);
        }

        $this->repository->save($glossary);
    }
}