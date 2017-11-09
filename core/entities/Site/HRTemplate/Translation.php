<?php

namespace core\entities\Site\HRTemplate;

use yii\db\ActiveRecord;

/**
 * Class Translation
 * @package core\entities\Site\Gallery
 * @property int id
 * @property int $template_id
 * @property string $language
 * @property string $title
 */
class Translation extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%hr_templatesLang}}';
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