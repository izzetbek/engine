<?php

namespace core\entities\Webinar;

use yii\db\ActiveRecord;
use core\entities\behaviors\MetaBehavior;
use core\entities\Meta;

/**
 * Class Translation
 * @property int id
 * @property int $webinar_id
 * @property string $language
 * @property string $title
 * @property string $site_description
 * @property string $cabinet_description
 * @property Meta $meta
 */
class Translation extends ActiveRecord
{
    public $meta;

    public static function tableName()
    {
        return '{{%webinarsLang}}';
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
        return $this->webinar_id === $id && $this->language === $language;
    }

    public static function create($language, $title, $siteDescription, $cabinetDescription, Meta $meta)
    {
        $translation = new self();
        $translation->language = $language;
        $translation->title = $title;
        $translation->site_description = $siteDescription;
        $translation->cabinet_description = $cabinetDescription;
        $translation->meta = $meta;

        return $translation;
    }
}