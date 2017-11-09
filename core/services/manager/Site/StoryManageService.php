<?php

namespace core\services\manager\Site;

use core\entities\Site\SuccessStory\SuccessStory;
use core\forms\manager\Site\SuccessStory\StoryForm;
use core\repositories\Site\SuccessStoryRepository;
use core\services\manager\ManagerService;

class StoryManageService extends ManagerService
{
    public function __construct(SuccessStoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(StoryForm $form) {
        if ($form->imageFile) {
            $form->thumb = self::saveFile($form->imageFile, 'stories');
        }
        $story = SuccessStory::create($form->thumb, $form->company, $form->order, $form->draft);
        foreach ($form->translations as $translation) {
            $story->addTranslation(
                $translation->language,
                $translation->name,
                $translation->position,
                $translation->story
            );
        }
        $this->repository->save($story);
        return $story->id;
    }

    public function edit($id, StoryForm $form)
    {
        $story = $this->repository->get($id);
        /** $@var SuccessStory $story */
        if ($form->imageFile) {
            if ($form->thumb) {
                self::saveFile($form->imageFile, 'team', $form->thumb);
            } else {
                $form->thumb = self::saveFile($form->imageFile, 'team');
            }
        }
        $story->edit($form->thumb, $form->company, $form->order, $form->draft);
        $story->revokeTranslations();
        foreach ($form->translations as $translation) {
            $story->addTranslation(
                $translation->language,
                $translation->name,
                $translation->position,
                $translation->story
            );
        }
        $this->repository->save($story);
    }

    public function deleteThumb($id)
    {
        $story = $this->repository->get($id);
        /** $@var SuccessStory $story */
        if (!$story->thumb) {
            throw new \DomainException('Image doesn`t exist');
        }
        unlink(\Yii::getAlias('@frontend/web/upload/stories/' . $story->thumb));
        $story->thumb = null;
        $this->repository->save($story);
    }
}