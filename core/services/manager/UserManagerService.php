<?php

namespace core\services\manager;

use core\entities\User\User;
use core\forms\manager\User\UserEditForm;
use core\repositories\UserRepository;
use core\forms\manager\User\UserCreateForm;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class UserManagerService
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(UserCreateForm $form)
    {
        if ($form->imageFile) {
            $form->thumb = self::saveFile($form->imageFile, User::SAVE_FOLDER);
        }
        $user = User::create(
            $form->username,
            $form->name,
            $form->surname,
            $form->company,
            $form->phone,
            $form->thumb,
            $form->email,
            $form->password,
            $form->role
        );
        $this->repository->save($user);
        return $user;
    }

    public function edit($id, UserEditForm $form)
    {
        $user = $this->repository->get($id);
        if ($form->imageFile) {
            if ($form->thumb) {
                self::saveFile($form->imageFile, User::SAVE_FOLDER, $form->thumb);
            } else {
                $form->thumb = self::saveFile($form->imageFile, User::SAVE_FOLDER);
            }
        }
        $user->edit(
            $form->username,
            $form->name,
            $form->surname,
            $form->company,
            $form->phone,
            $form->thumb,
            $form->email,
            $form->role
        );
        $this->repository->save($user);
        return $user;
    }

    public function deactivate($id)
    {
        $user = $this->repository->get($id);
        $user->deactivate();
        $this->repository->save($user);
    }

    public function activate($id)
    {
        $user = $this->repository->get($id);
        $user->activate();
        $this->repository->save($user);
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
}