<?php

namespace core\services\manager;

use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use core\entities\Meta;
use core\entities\Training\Training;
use core\forms\manager\Training\TrainingForm;
use core\repositories\TrainingRepository;

class TrainingManageService
{
    private $repository;

    public function __construct(TrainingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(TrainingForm $form)
    {
        if ($form->imageFile) {
            $form->thumb = self::saveFile($form->imageFile, Training::SAVE_FOLDER);
        }
        $training = Training::create($form->thumb, $form->price, $form->beginDate);
        foreach ($form->translations as $translation) {
            $training->addTranslation(
                $translation->language,
                $translation->title,
                $translation->description,
                new Meta(
                    $translation->meta->title,
                    $translation->meta->description,
                    $translation->meta->keywords
                )
            );
        }
        $this->repository->save($training);
        return $training->id;
    }

    public function edit($id, TrainingForm $form)
    {
        $training = $this->repository->get($id);
        /** @var Training $training */
        if ($form->imageFile) {
            if ($form->thumb) {
                self::saveFile($form->imageFile, Training::SAVE_FOLDER, $form->thumb);
            } else {
                $form->thumb = self::saveFile($form->imageFile, Training::SAVE_FOLDER);
            }
        }
        $training->edit($form->thumb, $form->price, $form->beginDate);
        $training->revokeTranslations();
        foreach ($form->translations as $translation) {
            $training->addTranslation(
                $translation->language,
                $translation->title,
                $translation->description,
                new Meta(
                    $translation->meta->title,
                    $translation->meta->description,
                    $translation->meta->keywords
                )
            );
        }
        $this->repository->save($training);
    }

    public static function saveFile(UploadedFile $file, $folder = null, $filename = null)
    {
        if (!$filename) {
            $filename = \Yii::$app->security->generateRandomString() . '.' . $file->getExtension();
        }
        $savePath = \Yii::getAlias('@frontend') . '/web/upload';
        if ($folder) {
            $savePath .= '/' . $folder;
            if (!file_exists($savePath)) {
                FileHelper::createDirectory($savePath);
            }
        }
        $file->saveAs($savePath . '/' . $filename);
        return $filename;
    }

    public function deleteThumb($id)
    {
        $training = $this->repository->get($id);
        /** @var Training $training */
        if (!$training->thumb) {
            throw new \DomainException('Image doesn`t exist');
        }
        unlink(\Yii::getAlias('@frontend/web/upload/' . Training::SAVE_FOLDER . '/' . $training->thumb));
        $training->thumb = null;
        $this->repository->save($training);
    }
}