<?php

namespace core\entities\Site\Article;

use yii\db\ActiveRecord;
use core\entities\behaviors\MetaBehavior;
use core\entities\Meta;

/**
 * Class Translation
 * @package core\entities\Site\Category
 * @property int $article_id
 * @property string $language
 * @property string $title
 * @property string $description
 * @property Meta $meta
 */
class Translation extends ActiveRecord
{
    public $meta;

    public static function tableName()
    {
        return '{{%articlesLang}}';
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
        return $this->article_id === $id && $this->language === $language;
    }

    public static function create($language, $title, $description, Meta $meta)
    {
        $translation = new self();
        $translation->language = $language;
        $translation->title = $title;
        $translation->description = $description;
        $translation->meta = $meta;

        return $translation;
    }
}