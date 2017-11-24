<?php

namespace core\services\manager;

use core\entities\Meta;
use core\entities\Vacancy\Vacancy;
use core\forms\manager\Vacancy\VacancyForm;
use core\repositories\VacancyRepoitory;

class VacancyManageService
{
    private $vacancies;

    public function __construct(VacancyRepoitory $vacancies)
    {
        $this->vacancies = $vacancies;
    }

    public function create(VacancyForm $form)
    {
        $vacancy = Vacancy::create($form->userId, strtotime($form->startDate), strtotime($form->endDate), $form->draft);
        foreach ($form->translations as $translation) {
            $vacancy->addTranslation(
                $translation->language,
                $translation->title,
                $translation->location,
                $translation->description,
                new Meta(
                    $translation->meta->title,
                    $translation->meta->keywords,
                    $translation->meta->description
                )
            );
        }
        $this->vacancies->save($vacancy);
        return $vacancy->id;
    }

    public function edit($id, VacancyForm $form)
    {
        $vacancy = $this->vacancies->get($id);
        /** @var Vacancy $vacancy */
        $vacancy->edit(strtotime($form->startDate), strtotime($form->endDate), $form->draft);
        $vacancy->revokeTranslations();
        foreach ($form->translations as $translation) {
            $vacancy->addTranslation(
                $translation->language,
                $translation->title,
                $translation->location,
                $translation->description,
                new Meta(
                    $translation->meta->title,
                    $translation->meta->keywords,
                    $translation->meta->description
                )
            );
        }
        $this->vacancies->save($vacancy);
    }
}