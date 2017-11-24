<?php

namespace core\entities\Vacancy;

use yii\db\ActiveRecord;
use core\entities\behaviors\MetaBehavior;
use core\entities\Meta;

/**
 * Class Translation
 * @property int id
 * @property int $vacancy_id
 * @property string $language
 * @property string $title
 * @property string $location
 * @property string $description
 * @property Meta $meta
 */
class Translation extends ActiveRecord
{
    public $meta;

    public static function tableName()
    {
        return '{{%vacanciesLang}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => MetaBehavior::className(),
                'attribute' => 'meta',
                'jsonAttribute' => 'meta_json',
            ],
        ];
    }

    public function isFor($id, $language)
    {
        return $this->vacancy_id === $id && $this->language === $language;
    }

    public static function create($language, $title, $location, $description, Meta $meta)
    {
        $translation = new self();
        $translation->language = $language;
        $translation->title = $title;
        $translation->location = $location;
        $translation->description = $description;
        $translation->meta = $meta;

        return $translation;
    }
}