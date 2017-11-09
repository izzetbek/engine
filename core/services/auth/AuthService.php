<?php

namespace core\services\auth;

use core\forms\auth\LoginForm;
use core\repositories\UserRepository;

class AuthService
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function auth(LoginForm $form)
    {
        $user = $this->users->getByUsernameOrPassword($form->username);
        if(!$user || !$user->isActive() || !$user->validatePassword($form->password)) {
            throw new \DomainException('Undefined user.');
        }
        return $user;
    }
}