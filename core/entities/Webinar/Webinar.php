<?php

namespace core\entities\Webinar;

use core\entities\User\User;
use yii\db\ActiveRecord;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use core\entities\behaviors\MetaBehavior;
use core\entities\Meta;

/**
 * Class Webinar
 * @property integer $id
 * @property integer $price
 * @property integer $beginDate
 * @property integer $status
 *
 * @property Translation[] $translations
 * @property Translation $translation
 */
class Webinar extends ActiveRecord
{
    const STATUS_NOT_STARTED = 5;
    const STATUS_ACTIVE = 10;
    const STATUS_FINISHED = 15;

    public static function tableName()
    {
        return '{{%webinars}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['translations'],
            ],
        ];
    }

    public static function create($price, $beginDate)
    {
        $webinar = new self();
        $webinar->price = $price;
        $webinar->beginDate = $beginDate;
        $webinar->status = self::STATUS_NOT_STARTED;

        return $webinar;
    }

    public function edit($price, $beginDate)
    {
        $this->price = $price;
        $this->beginDate = $beginDate;
    }

    //Translations

    public function addTranslation($language, $title, $siteDescription, $cabinetDescription, Meta $meta)
    {
        $translations = $this->translations;
        foreach ($translations as $i => $translation) {
            if ($translation->isFor($this->id, $language)) {
                return;
            }
        }
        $translations[] = Translation::create($language, $title, $siteDescription, $cabinetDescription, $meta);
        $this->translations = $translations;
    }

    public function revokeTranslations()
    {
        $this->translations = [];
    }

    #####

    public function getTranslations()
    {
        return $this->hasMany(Translation::className(), ['webinar_id' => 'id']);
    }
    public function getTranslation($language = null)
    {
        $language = ($language)? $language : \Yii::$app->params['defaultLanguage'];
        return $this->hasOne(Translation::className(), ['webinar_id' => 'id'])->andWhere(['language' => $language]);
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('{{%users_webinars}}', ['webinar_id' => 'id']);
    }

    #####
}