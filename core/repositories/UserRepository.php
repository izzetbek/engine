<?php

namespace core\repositories;

use core\entities\User\User;

class UserRepository
{
    public function existsByPasswordResetToken($token)
    {
        return (bool) User::findByPasswordResetToken($token);
    }

    public function getByPasswordResetToken($token)
    {
        $user = $this->getBy(['password_reset_token' => $token]);
        return $user;
    }

    public function getByUsernameOrPassword($value)
    {
        if(!$user = User::find()->where(['username' => $value])->orWhere(['email' => $value])->limit(1)->one()) {
            throw new NotFoundException('User not found');
        }
        return $user;
    }

    public function getByNetworkIdentity($network, $identity)
    {
        if($user = User::find()->joinWith('networks n')->andWhere(['n.network' => $network, 'n.identity' => $identity])->one()) {
            throw new NotFoundException('User not found');
        }
        return $user;
    }

    public function getByEmail(string $email)
    {
        $user = $this->getBy(['status' => User::STATUS_ACTIVE, 'email' => $email]);
        return $user;
    }

    public function save(User $user)
    {
        if (!$user->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function getByEmailConfirmToken($token)
    {
        $user = $this->getBy(['email_confirm_token' => $token]);
        return $user;
    }

    public function get($id)
    {
        $user = $this->getBy(['id' => $id]);
        return $user;
    }

    private function getBy(array $condition)
    {
        if(!$user = User::find()->andWhere($condition)->limit(1)->one()) {
            throw new NotFoundException('User not found');
        }

        return $user;
    }
}