<?php

namespace core\services\manager\Site;

use core\entities\Site\HRTemplate\Template;
use core\forms\manager\Site\HRTemplate\TemplateForm;
use core\repositories\Site\HRTemplateRepository;
use core\services\manager\ManagerService;

class HRTemplateManageService extends ManagerService
{
    public function __construct(HRTemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(TemplateForm $form)
    {
        if ($form->textFile) {
            $form->file = self::saveFile($form->textFile, 'templates');
        }
        $template = Template::create($form->file, $form->order, $form->draft);
        foreach ($form->translations as $translation) {
            $template->addTranslation(
                $translation->language,
                $translation->title
            );
        }
        $this->repository->save($template);
        return $template->id;
    }

    public function edit($id, TemplateForm $form)
    {
        $template = $this->repository->get($id);
        /** $@var Template $template */
        if ($form->textFile) {
            if ($form->file) {
                self::saveFile($form->textFile, 'templates', $form->file);
            } else {
                $form->file = self::saveFile($form->textFile, 'templates');
            }
        }
        $template->edit($form->file, $form->order, $form->draft);
        $template->revokeTranslations();
        foreach ($form->translations as $translation) {
            $template->addTranslation(
                $translation->language,
                $translation->title
            );
        }
        $this->repository->save($template);
    }

    public function deleteThumb($id)
    {
        $template = $this->repository->get($id);
        /** $@var Template $template */
        if (!$template->file) {
            throw new \DomainException('File doesn`t exist');
        }
        unlink(\Yii::getAlias('@frontend/web/upload/templates/' . $template->file));
        $template->file = null;
        $this->repository->save($template);
    }
}