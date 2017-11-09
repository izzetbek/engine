<?php

namespace core\entities\Site\SuccessStory;

use yii\db\ActiveRecord;

/**
 * Class Translation
 * @package core\entities\Site\Gallery
 * @property int id
 * @property int $story_id
 * @property string $language
 * @property string $name
 * @property string $position
 * @property string $story
 */
class Translation extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%success_storiesLang}}';
    }

    public static function create($language, $name, $position, $story)
    {
        $translation = new self();
        $translation->language = $language;
        $translation->name = $name;
        $translation->position = $position;
        $translation->story = $story;
        return $translation;
    }

    public function edit($name, $position, $story)
    {
        $this->name = $name;
        $this->position = $position;
        $this->story = $story;
    }

    public function hasTranslationFor($language)
    {
        return $this->language === $language;
    }

    public function isFor($id, $language)
    {
        return $this->story_id === $id && $this->language === $language;
    }
}