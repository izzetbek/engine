<?php

namespace core\entities\Site\SuccessStory;

use yii\db\ActiveRecord;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;

/**
 * @property string $thumb
 * @property string $company
 * @property integer $order
 * @property boolean $draft
 *
 * @property Translation[] $translations
 * @property Translation $translation
 */
class SuccessStory extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['translations'],
            ],
        ];
    }

    public static function tableName()
    {
        return '{{%success_stories}}';
    }

    public function isDraft()
    {
        return $this->draft == true;
    }

    public static function create($thumb, $company, $order, $draft)
    {
        $teller = new self();
        $teller->thumb = $thumb;
        $teller->company = $company;
        $teller->order = $order;
        $teller->draft = $draft;

        return $teller;
    }

    public function edit($thumb, $company, $order, $draft)
    {
        $this->thumb = $thumb;
        $this->company = $company;
        $this->order = $order;
        $this->draft = $draft;
    }

    //Translations

    public function addTranslation($language, $name, $position, $story)
    {
        $translations = $this->translations;
        foreach ($translations as $i => $translation) {
            /** @var Translation $translation */
            if ($translation->isFor($this->id, $language)) {
                return;
            }
        }
        $translations[] = Translation::create($language, $name, $position, $story);
        $this->translations = $translations;
    }

    public function revokeTranslations()
    {
        $this->translations = [];
    }


    #####

    public function getTranslations()
    {
        return $this->hasMany(Translation::className(), ['story_id' => 'id']);
    }
    public function getTranslation($language = null)
    {
        $language = ($language)? $language : \Yii::$app->params['defaultLanguage'];
        return $this->hasOne(Translation::className(), ['story_id' => 'id'])->andWhere(['language' => $language]);
    }

    #####
}