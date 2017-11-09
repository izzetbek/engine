<?php

namespace core\services\manager;

use core\entities\Meta;
use core\entities\Webinar\Webinar;
use core\forms\manager\Webinar\WebinarForm;
use core\repositories\WebinarRepository;

class WebinarManageService
{
    private $repository;

    public function __construct(WebinarRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(WebinarForm $form)
    {
        $webinar = Webinar::create($form->price, strtotime($form->beginDate));
        foreach ($form->translations as $translation) {
            $webinar->addTranslation(
                $translation->language,
                $translation->title,
                $translation->siteDescription,
                $translation->cabinetDescription,
                new Meta(
                    $translation->meta->title,
                    $translation->meta->keywords,
                    $translation->meta->description
                )
            );
        }
        $this->repository->save($webinar);
        return $webinar->id;
    }

    public function edit($id, WebinarForm $form)
    {
        $webinar = $this->repository->get($id);
        /** @var Webinar $webinar */
        $webinar->edit($form->price, $form->beginDate);
        $webinar->revokeTranslations();
        foreach ($form->translations as $translation) {
            $webinar->addTranslation(
                $translation->language,
                $translation->title,
                $translation->siteDescription,
                $translation->cabinetDescription,
                new Meta(
                    $translation->meta->title,
                    $translation->meta->keywords,
                    $translation->meta->description
                )
            );
        }
        $this->repository->save($webinar);
    }

    public function remove($id)
    {

    }
}