<?php

namespace core\services\manager\OnlineTest;

use core\entities\Meta;
use core\entities\OnlineTest\Test\OnlineTest;
use core\forms\manager\OnlineTest\Test\OnlineTestForm;
use core\repositories\OnlineTest\OnlineTestRepository;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class TestManageService
{
    private $repository;

    public function __construct(OnlineTestRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(OnlineTestForm $form)
    {
        if ($form->imageFile) {
            $form->thumb = self::saveFile($form->imageFile, 'onlineTests');
        }
        $onlineTest = OnlineTest::create($form->thumb, $form->price, $form->status);
        foreach ($form->translations as $translation) {
            $onlineTest->addTranslation(
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
        $this->repository->save($onlineTest);
        return $onlineTest->id;
    }

    public function edit($id, OnlineTestForm $form)
    {
        $onlineTest = $this->repository->get($id);
        /** @var OnlineTest $onlineTest */
        if ($form->imageFile) {
            if ($form->thumb) {
                self::saveFile($form->imageFile, 'onlineTests', $form->thumb);
            } else {
                $form->thumb = self::saveFile($form->imageFile, 'onlineTests');
            }
        }
        $onlineTest->edit($form->thumb, $form->price, $form->status);
        $onlineTest->revokeTranslations();
        foreach ($form->translations as $translation) {
            $onlineTest->addTranslation(
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
        $this->repository->save($onlineTest);
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
}