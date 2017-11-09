<?php

namespace core\entities\OnlineTest\Test;

use core\entities\OnlineTest\Question\Question;
use yii\db\ActiveRecord;
use core\entities\Meta;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;

/**
 * Class OnlineTest
 * @property integer $id
 * @property string $thumb
 * @property integer $price
 * @property integer $passed_by
 * @property integer $created_at
 * @property integer $status
 *
 * @property Translation[] $translations
 * @property Translation $translation
 *
 * @property Question[] $questions
 */
class OnlineTest extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static function tableName()
    {
        return '{{%online_tests}}';
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

    public static function create($thumb, $price, $status)
    {
        $onlineTest = new self();
        $onlineTest->thumb = $thumb;
        $onlineTest->price = $price;
        $onlineTest->status = $status;
        $onlineTest->created_at = time();
        return $onlineTest;
    }

    public function edit($thumb, $price, $status)
    {
        $this->thumb = $thumb;
        $this->price = $price;
        $this->status = $status;
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
        return $this->hasMany(Translation::className(), ['test_id' => 'id']);
    }
    public function getTranslation($language = null)
    {
        $language = ($language)? $language : \Yii::$app->params['defaultLanguage'];
        return $this->hasOne(Translation::className(), ['test_id' => 'id'])->andWhere(['language' => $language]);
    }

    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['test_id' => 'id']);
    }

    #####
}