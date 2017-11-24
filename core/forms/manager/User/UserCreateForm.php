<?php

namespace core\forms\manager\User;

use yii\web\UploadedFile;
use yii\base\Model;

class UserCreateForm extends Model
{
    public $username;
    public $name;
    public $surname;
    public $company;
    public $phone;
    /** @var  UploadedFile $imageFile */
    public $imageFile;
    public $thumb;
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

            [['name', 'surname'], 'required'],
            [['name', 'surname', 'company'], 'string', 'max' => 255],
            ['phone', 'match', 'pattern' => '^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$'],
            ['imageFile', 'file', 'extensions' => 'png, jpg'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\core\entities\User\User', 'message' => 'This email address has already been taken.'],
        ];
    }
}