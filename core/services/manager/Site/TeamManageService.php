<?php

namespace core\services\manager\Site;

use core\entities\Site\Team\Team;
use core\forms\manager\Site\Team\TeamForm;
use core\repositories\Site\TeamRepository;
use core\services\manager\ManagerService;

class TeamManageService extends ManagerService
{
    public function __construct(TeamRepository $teammates)
    {
        $this->repository = $teammates;
    }

    public function create(TeamForm $form)
    {
        if ($form->imageFile) {
            $form->thumb = self::saveFile($form->imageFile, 'team');
        }
        $teammate = Team::create($form->thumb, $form->order, $form->draft);
        foreach ($form->translations as $translation) {
            $teammate->addTranslation(
                $translation->language,
                $translation->name,
                $translation->position,
                $translation->description
            );
        }
        $this->repository->save($teammate);
        return $teammate->id;
    }

    public function edit($id, TeamForm $form)
    {
        $teammate = $this->repository->get($id);
        /** @var Team $teammate */
        if ($form->imageFile) {
            if ($form->thumb) {
                self::saveFile($form->imageFile, 'team', $form->thumb);
            } else {
                $form->thumb = self::saveFile($form->imageFile, 'team');
            }
        }
        $teammate->edit($form->thumb, $form->order, $form->draft);
        $teammate->revokeTranslations();
        foreach ($form->translations as $translation) {
            $teammate->addTranslation(
                $translation->language,
                $translation->name,
                $translation->position,
                $translation->description
            );
        }
        $this->repository->save($teammate);
    }

    public function deleteThumb($id)
    {
        $teammate = $this->repository->get($id);
        /** $@var Team $teammate */
        if (!$teammate->thumb) {
            throw new \DomainException('Image doesn`t exist');
        }
        unlink(\Yii::getAlias('@frontend/web/upload/team/' . $teammate->thumb));
        $teammate->thumb = null;
        $this->repository->save($teammate);
    }
}