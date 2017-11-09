<?php

namespace core\entities\OnlineTest\Variant;

use yii\db\ActiveRecord;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;

/**
 * @property integer $id
 * @property integer $question_id
 * @property boolean $correct
 *
 * @property Translation[] $translations
 * @property Translation $translation
 */
class Variant extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%questions_variants}}';
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

    public static function create($correct)
    {
        $variant = new self();
        $variant->correct = $correct;
        return $variant;
    }

    public function edit($correct)
    {
        $this->correct = $correct;
    }

    public function isFor($id)
    {
        return $this->question_id === $id;
    }

    public function isEqualTo($id)
    {
        return $this->id === $id;
    }

    public function addTranslation($language, $content)
    {
        $translations = $this->translations;
        foreach ($translations as $i => $translation) {
            if ($translation->isFor($this->id, $language)) {
                return;
            }
        }
        $translations[] = Translation::create($language, $content);
        $this->translations = $translations;
    }

    public function revokeTranslations()
    {
        $this->translations = [];
    }

    #####

    public function getTranslations()
    {
        return $this->hasMany(Translation::className(), ['variant_id' => 'id']);
    }
    public function getTranslation($language = null)
    {
        $language = ($language)? $language : \Yii::$app->params['defaultLanguage'];
        return $this->hasOne(Translation::className(), ['variant_id' => 'id'])->andWhere(['language' => $language]);
    }

    #####
}