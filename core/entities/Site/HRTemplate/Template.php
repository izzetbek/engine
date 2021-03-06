<?php

namespace core\entities\Site\HRTemplate;

use yii\db\ActiveRecord;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;

/**
 * @property int $id
 * @property string $file
 * @property int $order
 * @property int $draft
 *
 * @property Translation[] $translations
 * @property Translation $translation
 */
class Template extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%hr_templates}}';
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

    public static function create($file, $order, $draft)
    {
        $teammate = new static();
        $teammate->file = $file;
        $teammate->order = $order;
        $teammate->draft = $draft;
        return $teammate;
    }

    public function edit($file, $order, $draft)
    {
        $this->file = $file;
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

    public function addTranslation($language, $title)
    {
        $translations = $this->translations;
        foreach ($translations as $i => $translation) {
            /** @var Translation $translation */
            if ($translation->isFor($this->id, $language)) {
                return;
            }
        }
        $translations[] = Translation::create($language, $title);
        $this->translations = $translations;
    }

    public function revokeTranslations()
    {
        $this->translations = [];
    }


    #####

    public function getTranslations()
    {
        return $this->hasMany(Translation::className(), ['template_id' => 'id']);
    }
    public function getTranslation($language = null)
    {
        $language = ($language)? $language : \Yii::$app->params['defaultLanguage'];
        return $this->hasOne(Translation::className(), ['template_id' => 'id'])->andWhere(['language' => $language]);
    }

    #####
}