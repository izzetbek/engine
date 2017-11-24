<?php

namespace core\services\manager;

use core\entities\Meta;
use core\entities\Webinar\Webinar;
use core\forms\manager\Webinar\WebinarForm;
use core\repositories\WebinarRepository;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class WebinarManageService
{
    private $repository;

    public function __construct(WebinarRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(WebinarForm $form)
    {
        if ($form->imageFile) {
            $form->thumb = self::saveFile($form->imageFile, Webinar::SAVE_FOLDER);
        }
        $webinar = Webinar::create($form->thumb, $form->price, strtotime($form->beginDate));
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
        if ($form->imageFile) {
            if ($form->thumb) {
                self::saveFile($form->imageFile, Webinar::SAVE_FOLDER, $form->thumb);
            } else {
                $form->thumb = self::saveFile($form->imageFile, Webinar::SAVE_FOLDER);
            }
        }
        $webinar->edit($form->thumb, $form->price, strtotime($form->beginDate));
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

    private static function saveFile(UploadedFile $file, $folder = null, $filename = null)
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
        $webinar = $this->repository->get($id);
        /** @var Webinar $webinar */
        if (!$webinar->thumb) {
            throw new \DomainException('Image doesn`t exist');
        }
        unlink(\Yii::getAlias('@frontend/web/upload/' . Webinar::SAVE_FOLDER . '/' . $webinar->thumb));
        $webinar->thumb = null;
        $this->repository->save($webinar);
    }
}