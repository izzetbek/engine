<?php

namespace core\entities\Site\Glossary;

use yii\db\ActiveRecord;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;

/**
 * @property int $id
 * @property int $draft
 *
 * @property Translation[] $translations
 */
class Glossary extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%glossary}}';
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

    public static function create($draft)
    {
        $glossary = new self();
        $glossary->draft = $draft;
        return $glossary;
    }

    public function edit($draft)
    {
        $this->draft = $draft;
    }

    public function isDraft()
    {
        return $this->draft == true;
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    //Translations

    public function addTranslation($language, $title, $description)
    {
        $translations = $this->translations;
        foreach ($translations as $i => $translation) {
            /** @var Translation $translation */
            if ($translation->isFor($this->id, $language)) {
                return;
            }
        }
        $translations[] = Translation::create($language, $title, $description);
        $this->translations = $translations;
    }

    public function revokeTranslations()
    {
        $this->translations = [];
    }


    #####

    public function getTranslations()
    {
        return $this->hasMany(Translation::className(), ['glossary_id' => 'id']);
    }
    public function getTranslation($language = null)
    {
        $language = ($language)? $language : \Yii::$app->params['defaultLanguage'];
        return $this->hasOne(Translation::className(), ['glossary_id' => 'id'])->andWhere(['language' => $language]);
    }

    #####
}