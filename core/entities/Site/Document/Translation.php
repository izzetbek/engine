<?php

namespace core\entities\Site\Document;

use yii\db\ActiveRecord;

/**
 * Class Translation
 * @property int id
 * @property int $template_id
 * @property string $language
 * @property string $title
 */
class Translation extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%documentsLang}}';
    }

    public static function create($language, $title)
    {
        $translation = new self();
        $translation->language = $language;
        $translation->title = $title;
        return $translation;
    }

    public function edit($title)
    {
        $this->title = $title;
    }

    public function hasTranslationFor($language)
    {
        return $this->language === $language;
    }

    public function isFor($id, $language)
    {
        return $this->template_id === $id && $this->language === $language;
    }
}