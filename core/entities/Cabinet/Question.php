<?php

namespace core\entities\Cabinet;

use core\entities\User\User;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $question
 * @property integer $ask_date
 * @property integer $status
 *
 * @property User $user
 * @property Answer[] $answers
 */
class Question extends ActiveRecord
{
    const STATUS_WAIT = 0;
    const STATUS_ANSWERED = 10;

    public static function tableName()
    {
        return '{{%questions}}';
    }

    public static function create($userId, $title, $question)
    {
        $object = new static();
        $object->user_id = $userId;
        $object->title = $title;
        $object->question = $question;
        $object->ask_date = time();
        $object->status = self::STATUS_WAIT;
        return $object;
    }

    public function edit($title, $quetion)
    {
        $this->title = $title;
        $this->question = $quetion;
    }

    public function complete()
    {
        $this->status = self::STATUS_ANSWERED;
    }

    public function open()
    {
        $this->status = self::STATUS_WAIT;
    }

    public function isComplete()
    {
        return $this->status === self::STATUS_ANSWERED;
    }

    public function isFrom($id)
    {
        return $this->user_id === $id;
    }

    public static function getUnAnsweredQuantity()
    {
        return self::find()->andWhere(['status' => self::STATUS_WAIT])->count();
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getAnswers()
    {
        return $this->hasMany(Answer::className(), ['question_id' => 'id']);
    }
}