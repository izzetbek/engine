<?php

namespace core\entities\OnlineTest\Question;

use core\entities\OnlineTest\Test\OnlineTest;
use core\entities\OnlineTest\Variant\Variant;
use yii\db\ActiveRecord;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;

/**
 * @property integer $id
 * @property integer $test_id
 * @property integer $order
 *
 * @property Translation[] $translations
 * @property Variant[] $variants
 * @property Translation $translation
 */
class Question extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%online_tests_questions}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['translations', 'variants'],
            ],
        ];
    }

    public static function create($test_id, $order)
    {
        $question = new self();
        $question->test_id = $test_id;
        $question->order = $order;
        return $question;
    }

    public function edit($test_id, $order)
    {
        $this->test_id = $test_id;
        $this->order = $order;
    }

    //Variants

    public function addVariant(Variant $variant)
    {
        $variants = $this->variants;
        if ($variant->isFor($this->id)) {
            return;
        }
        $variants[] = $variant;
        $this->variants = $variants;
    }

    public function revokeVariants()
    {
        $this->variants = [];
    }

    //Translations

    public function addTranslation($language, $title)
    {
        $translations = $this->translations;
        foreach ($translations as $i => $translation) {
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
        return $this->hasMany(Translation::className(), ['question_id' => 'id']);
    }
    public function getTranslation($language = null)
    {
        $language = ($language)? $language : \Yii::$app->params['defaultLanguage'];
        return $this->hasOne(Translation::className(), ['question_id' => 'id'])->andWhere(['language' => $language]);
    }

    public function getVariants()
    {
        return $this->hasMany(Variant::className(), ['question_id' => 'id']);
    }

    public function getTest()
    {
        return $this->hasOne(OnlineTest::className(), ['id' => 'test_id'])->joinWith('translations');
    }

    #####
}