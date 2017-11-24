<?php

namespace core\entities\Vacancy;

use core\entities\User\User;
use yii\db\ActiveRecord;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use core\entities\Meta;

/**
 * Class Vacancy
 * @property integer $id
 * @property integer $user_id
 * @property integer $start_date
 * @property integer $end_date
 * @property boolean $draft
 *
 * @property Translation[] $translations
 * @property Translation $translation
 * @property User $user
 */
class Vacancy extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%vacancies}}';
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

    public static function create($userId, $startDate, $endDate, $draft)
    {
        $vacancy = new self();
        $vacancy->user_id = $userId;
        $vacancy->start_date = $startDate;
        $vacancy->end_date = $endDate;
        $vacancy->draft = $draft;

        return $vacancy;
    }

    public function edit($startDate, $endDate, $draft)
    {
        $this->start_date = $startDate;
        $this->end_date = $endDate;
        $this->draft = $draft;
    }

    //Translations

    public function addTranslation($language, $title, $location, $description, Meta $meta)
    {
        $translations = $this->translations;
        foreach ($translations as $i => $translation) {
            if ($translation->isFor($this->id, $language)) {
                return;
            }
        }
        $translations[] = Translation::create($language, $title, $location, $description, $meta);
        $this->translations = $translations;
    }

    public function revokeTranslations()
    {
        $this->translations = [];
    }

    #####

    public function getTranslations()
    {
        return $this->hasMany(Translation::className(), ['vacancy_id' => 'id']);
    }
    public function getTranslation($language = null)
    {
        $language = ($language)? $language : \Yii::$app->params['defaultLanguage'];
        return $this->hasOne(Translation::className(), ['vacancy_id' => 'id'])->andWhere(['language' => $language]);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    #####
}