<?php

namespace core\entities\Site\Gallery;

use yii\db\ActiveRecord;
use zxbodya\yii2\galleryManager\GalleryBehavior;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Imagine\Image\Box;
use yii;

/**
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Translation[] $translations
 */
class Gallery extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%gallery}}';
    }

    public function behaviors()
    {
        return [
            'galleryBehavior' => [
                'class' => GalleryBehavior::className(),
                'tableName' => '{{%gallery_album_photos}}',
                'type' => 'Album',
                'extension' => 'jpg',
                'directory' => Yii::getAlias('@webroot') . '/images/gallery',
                'url' => Yii::getAlias('@web') . '/images/gallery',
                'versions' => [
                    'small' => function ($img) {
                        /** @var \Imagine\Image\ImageInterface $img */
                        return $img->copy()->thumbnail(new Box(200, 200));
                    },
                    'medium' => function ($img) {
                        /** @var \Imagine\Image\ImageInterface $img */
                        $dstSize = $img->getSize();
                        $maxWidth = 800;
                        if ($dstSize->getWidth() > $maxWidth) {
                            $dstSize = $dstSize->widen($maxWidth);
                        }
                        return $img->copy()->resize($dstSize);
                    },
                ]
            ],
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['translations'],
            ],
        ];
    }

    public static function create()
    {
        $album = new static();
        $album->created_at = time();
        return $album;
    }

    public function edit()
    {
        $this->updated_at = time();
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    //Translations

    public function addTranslation($language, $name, $description)
    {
        $translations = $this->translations;
        foreach ($translations as $i => $translation) {
            /** @var Translation $translation */
            if ($translation->isFor($this->id, $language)) {
                return;
            }
        }
        $translations[] = Translation::create($language, $name, $description);
        $this->translations = $translations;
    }

    public function revokeTranslations()
    {
        $this->translations = [];
    }



    #####

    public function getTranslations()
    {
        return $this->hasMany(Translation::className(), ['album_id' => 'id']);
    }
    public function getTranslation($language = null)
    {
        $language = ($language)? $language : Yii::$app->params['defaultLanguage'];
        return $this->hasOne(Translation::className(), ['album_id' => 'id'])->andWhere(['language' => $language]);
    }

    #####
}