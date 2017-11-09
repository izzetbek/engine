<?php

namespace core\services\manager;

use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class ManagerService
{
    /** @var  Object $repository */
    protected $repository;

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

    public function moveUp($id)
    {
        $object = $this->repository->get($id);
        /** @var Object $object */
        try {
            $previous = $object->getPrevious();
            $object->order = $previous->order - 1;
            $this->repository->save($object);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash($e->getMessage());
        }
    }

    public function moveDown($id)
    {
        $object = $this->repository->get($id);
        /** @var Object $object */
        try {
            $next = $object->getNext();
            $object->order = $next->order + 1;
            $this->repository->save($object);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash($e->getMessage());
        }
    }
}