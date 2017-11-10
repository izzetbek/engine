<?php
namespace core\forms\auth;

use himiklab\yii2\recaptcha\ReCaptchaValidator;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $reCaptcha;
    public $rememberMe = true;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            ['reCaptcha', ReCaptchaValidator::className()],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
        ];
    }
}
