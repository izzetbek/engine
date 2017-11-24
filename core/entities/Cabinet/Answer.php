<?php

namespace core\entities\Cabinet;

use core\entities\User\User;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $user_id
 * @property int $question_id
 * @property int $parent_id
 * @property int $answer_date
 * @property string $content
 *
 * @property Question $question
 * @property User $user
 * @property Answer $parent
 */
class Answer extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%question_answers}}';
    }

    public static function create($userId, $questionId, $content)
    {
        $answer = new self();
        $answer->user_id = $userId;
        $answer->question_id = $questionId;
        $answer->content = $content;
        $answer->answer_date = time();
        return $answer;
    }

    public function edit($content)
    {
        $this->content = $content;
    }

    public function attachTo($id)
    {
        $this->parent_id = $id;
    }

    public function isFrom($id)
    {
        return $this->user_id === $id;
    }

    public function isChildOf($id)
    {
        return $this->parent_id === $id;
    }

    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }
}