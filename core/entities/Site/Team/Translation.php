<?php

namespace core\entities\Site\Team;

use yii\db\ActiveRecord;

/**
 * Class Translation
 * @package core\entities\Site\Gallery
 * @property int id
 * @property int $teammate_id
 * @property string $language
 * @property string $name
 * @property string $position
 * @property string $description
 */
class Translation extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%teamLang}}';
    }

    public static function create($language, $name, $position, $description)
    {
        $translation = new self();
        $translation->language = $language;
        $translation->name = $name;
        $translation->position = $position;
        $translation->description = $description;
        return $translation;
    }

    public function edit($name, $position, $description)
    {
        $this->name = $name;
        $this->position = $position;
        $this->description = $description;
    }

    public function hasTranslationFor($language)
    {
        return $this->language === $language;
    }

    public function isFor($id, $language)
    {
        return $this->teammate_id === $id && $this->language === $language;
    }
}