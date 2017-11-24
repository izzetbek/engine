<?php

namespace core\forms\manager\User;

use core\entities\User\User;
use yii\base\Model;
use yii\web\UploadedFile;

class UserEditForm extends Model
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
    public $role;

    public $_user;

    public function __construct(User $user, array $config = [])
    {
        $this->username = $user->username;
        $this->name = $user->name;
        $this->surname = $user->surname;
        $this->company = $user->company;
        $this->phone = $user->phone;
        $this->thumb = $user->thumb;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->_user = $user;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            [['username', 'email'], 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id]],

            [['name', 'surname'], 'required'],
            [['name', 'surname', 'company'], 'string', 'max' => 255],
            ['phone', 'match', 'pattern' => '^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$'],
            ['imageFile', 'file', 'extensions' => 'png, jpg'],
        ];
    }
}