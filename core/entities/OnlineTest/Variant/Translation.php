<?php

namespace core\entities\OnlineTest\Variant;

use yii\db\ActiveRecord;

/**
 * Class Translation
 * @property int id
 * @property int $variant_id
 * @property string $language
 * @property string $content
 */
class Translation extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%questions_variantsLang}}';
    }

    public function isFor($id, $language)
    {
        return $this->variant_id === $id && $this->language === $language;
    }

    public static function create($language, $content)
    {
        $translation = new self();
        $translation->language = $language;
        $translation->content = $content;

        return $translation;
    }
}