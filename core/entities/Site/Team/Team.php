<?php

namespace core\entities\Site\Team;

use yii\db\ActiveRecord;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii;

/**
 * @property int $id
 * @property string $thumb
 * @property int $order
 * @property int $draft
 *
 * @property Translation[] $translations
 */
class Team extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%team}}';
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

    public static function create($thumb, $order, $draft)
    {
        $teammate = new static();
        $teammate->thumb = $thumb;
        $teammate->order = $order;
        $teammate->draft = $draft;
        return $teammate;
    }

    public function edit($thumb, $order, $draft)
    {
        $this->thumb = $thumb;
        $this->order = $order;
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

    public function addTranslation($language, $name, $position, $description)
    {
        $translations = $this->translations;
        foreach ($translations as $i => $translation) {
            /** @var Translation $translation */
            if ($translation->isFor($this->id, $language)) {
                return;
            }
        }
        $translations[] = Translation::create($language, $name, $position, $description);
        $this->translations = $translations;
    }

    public function revokeTranslations()
    {
        $this->translations = [];
    }


    #####

    public function getTranslations()
    {
        return $this->hasMany(Translation::className(), ['teammate_id' => 'id']);
    }
    public function getTranslation($language = null)
    {
        $language = ($language)? $language : Yii::$app->params['defaultLanguage'];
        return $this->hasOne(Translation::className(), ['teammate_id' => 'id'])->andWhere(['language' => $language]);
    }

    #####
}