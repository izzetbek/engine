<?php

namespace core\services\auth;

use core\entities\User\User;
use core\repositories\UserRepository;
use core\forms\auth\SignupForm;
use yii\mail\MailerInterface;

class SignupService
{
    private $mailer;
    private $users;

    public function __construct(MailerInterface $mailer, UserRepository $users)
    {
        $this->mailer = $mailer;
        $this->users = $users;
    }

    public function requestSignup(SignupForm $form)
    {
        $user = User::requestSignup($form->username, $form->email, $form->password);
        $this->users->save($user);

        $sent = $this->mailer
            ->compose(
                ['html' => 'auth/signup/confirm-html', 'text' => 'auth/signup/confirm-text'],
                ['user' => $user]
            )
            ->setTo($form->email)
            ->setSubject('Signup request from ' . \Yii::$app->name)
            ->send();

        if(!$sent) {
            throw new \RuntimeException('Request mail sending error.');
        }
    }

    public function confirm($token)
    {
        if(empty($token)) {
            throw new \DomainException('Token is empty');
        }

        $user = $this->users->getByEmailConfirmToken($token);
        $user->confirmSignup();
        $this->users->save($user);
    }
}