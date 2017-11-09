<?php

namespace core\entities\Site\Glossary;

use yii\db\ActiveRecord;

/**
 * Class Translation
 * @package core\entities\Site\Glossary
 * @property int id
 * @property int $glossary_id
 * @property string $language
 * @property string $title
 * @property string $description
 */
class Translation extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%glossaryLang}}';
    }

    public static function create($language, $title, $description)
    {
        $translation = new self();
        $translation->language = $language;
        $translation->title = $title;
        $translation->description = $description;
        return $translation;
    }

    public function edit($title, $description)
    {
        $this->title = $title;
        $this->description = $description;
    }

    public function hasTranslationFor($language)
    {
        return $this->language === $language;
    }

    public function isFor($id, $language)
    {
        return $this->glossary_id === $id && $this->language === $language;
    }
}