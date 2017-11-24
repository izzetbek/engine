<?php

namespace core\entities\Training;

use yii\db\ActiveRecord;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use core\entities\Meta;
use core\entities\User\User;

/**
 * Class Training
 * @property integer $id
 * @property string $thumb
 * @property integer $price
 * @property integer $begin_date
 * @property boolean $draft
 *
 * @property Translation[] $translations
 * @property Translation $translation
 */
class Training extends ActiveRecord
{
    const SAVE_FOLDER = 'trainings';

    public static function tableName()
    {
        return '{{%trainings}}';
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

    public static function create($thumb, $price, $beginDate)
    {
        $training = new self();
        $training->thumb = $thumb;
        $training->price = $price;
        $training->begin_date = $beginDate;
        $training->draft = false;

        return $training;
    }

    public function edit($thumb, $price, $beginDate)
    {
        $this->thumb = $thumb;
        $this->price = $price;
        $this->begin_date = $beginDate;
    }

    //Translations

    public function addTranslation($language, $title, $description, Meta $meta)
    {
        $translations = $this->translations;
        foreach ($translations as $i => $translation) {
            if ($translation->isFor($this->id, $language)) {
                return;
            }
        }
        $translations[] = Translation::create($language, $title, $description, $meta);
        $this->translations = $translations;
    }

    public function revokeTranslations()
    {
        $this->translations = [];
    }

    #####

    public function getTranslations()
    {
        return $this->hasMany(Translation::className(), ['training_id' => 'id']);
    }
    public function getTranslation($language = null)
    {
        $language = ($language)? $language : \Yii::$app->params['defaultLanguage'];
        return $this->hasOne(Translation::className(), ['training_id' => 'id'])->andWhere(['language' => $language]);
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'users_id'])->viaTable('{{%users_trainings}}', ['trainings_id' => 'id']);
    }

    #####
}