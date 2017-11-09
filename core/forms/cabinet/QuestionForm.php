<?php

namespace core\forms\cabinet;

use yii\base\Model;

class QuestionForm extends Model
{
    public $webinar;
    public $body;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // webinar and body are required
            [['webinar', 'body'], 'required'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }
}