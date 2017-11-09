<?php

namespace core\entities\OnlineTest\Question;

use yii\db\ActiveRecord;

/**
 * Class Translation
 * @property int id
 * @property int $question_id
 * @property string $language
 * @property string $title
 */
class Translation extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%online_tests_questionsLang}}';
    }

    public function isFor($id, $language)
    {
        return $this->question_id === $id && $this->language === $language;
    }

    public static function create($language, $title)
    {
        $translation = new self();
        $translation->language = $language;
        $translation->title = $title;

        return $translation;
    }
}