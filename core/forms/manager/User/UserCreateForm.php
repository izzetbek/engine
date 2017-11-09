<?php

namespace core\forms\manager\User;

use yii\base\Model;

class UserCreateForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $role;

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\core\entities\User\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\core\entities\User\User', 'message' => 'This email address has already been taken.'],
        ];
    }
}