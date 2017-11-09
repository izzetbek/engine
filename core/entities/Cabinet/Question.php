<?php

namespace core\entities\Cabinet;

use core\entities\User\User;
use core\entities\Webinar\Webinar;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $webinar_id
 * @property string $question
 * @property string $answer
 * @property integer $ask_date
 * @property integer $status
 *
 * @property User $user
 * @property Webinar $webinar
 */
class Question extends ActiveRecord
{
    const STATUS_WAIT = 0;
    const STATUS_ANSWERED = 10;

    public static function tableName()
    {
        return '{{%questions}}';
    }

    public static function create($userId, $webinarId, $question)
    {
        $object = new static();
        $object->user_id = $userId;
        $object->webinar_id = $webinarId;
        $object->question = $question;
        $object->ask_date = time();
        $object->status = self::STATUS_WAIT;
        return $object;
    }

    public function answer($answer)
    {
        $this->answer = $answer;
        $this->status = self::STATUS_ANSWERED;
    }

    public static function getUnAnsweredQuantity()
    {
        return self::find()->andWhere(['status' => self::STATUS_WAIT])->count();
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getWebinar()
    {
        return $this->hasOne(Webinar::className(), ['id' => 'webinar_id']);
    }
}