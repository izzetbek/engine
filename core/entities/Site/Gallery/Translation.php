<?php

namespace core\entities\Site\Gallery;

use yii\db\ActiveRecord;

/**
 * Class Translation
 * @package core\entities\Site\Gallery
 * @property int id
 * @property int $album_id
 * @property string $language
 * @property string $name
 * @property string $description
 */
class Translation extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%galleryLang}}';
    }

    public static function create($language, $name, $description)
    {
        $translation = new self();
        $translation->language = $language;
        $translation->name = $name;
        $translation->description = $description;
        return $translation;
    }

    public function edit($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
    }

    public function hasTranslationFor($language)
    {
        return $this->language === $language;
    }

    public function isFor($id, $language)
    {
        return $this->album_id === $id && $this->language === $language;
    }
}