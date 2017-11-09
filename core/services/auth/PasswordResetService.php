<?php

namespace core\services\auth;

use core\entities\User\User;
use core\repositories\UserRepository;
use core\forms\auth\PasswordResetRequestForm;
use core\forms\auth\ResetPasswordForm;
use Yii;
use yii\mail\MailerInterface;

class PasswordResetService
{
    private $mailer;
    private $users;

    public function __construct(MailerInterface $mailer, UserRepository $users)
    {
        $this->mailer = $mailer;
        $this->users = $users;
    }

    public function request(PasswordResetRequestForm $form)
    {
        /* @var $user User */
        $user = $this->users->getByEmail($form->email);
        $user->requestPasswordReset();
        $this->users->save($user);

        $sent = $this
            ->mailer
            ->compose(
                ['html' => 'confirm-html', 'text' => 'confirm-text'],
                ['user' => $user]
            )
            ->setTo($form->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();

        if(!$sent) {
            throw new \RuntimeException('Request mail sending error.');
        }
    }

    public function validateToken($token)
    {
        if(empty($token) || !is_string($token)) {
            throw new \DomainException('Password reset token can`t be blank.');
        }
        if($this->users->existsByPasswordResetToken($token)) {
            throw new \DomainException('Wrong password reset token');
        }
    }

    public function reset($token, ResetPasswordForm $form)
    {
        $user = $this->users->getByPasswordResetToken($token);
        $user->resetPassword($form->password);
        $this->users->save($user);
    }
}