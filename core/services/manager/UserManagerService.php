<?php

namespace core\services\manager;

use core\entities\User\User;
use core\forms\manager\User\UserEditForm;
use core\repositories\UserRepository;
use core\forms\manager\User\UserCreateForm;

class UserManagerService
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(UserCreateForm $form)
    {
        $user = User::create(
            $form->username,
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
        $user->edit(
            $form->username,
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
}