<?php

namespace core\entities\Site\Article;

use yii\db\ActiveRecord;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use core\entities\Meta;

/**
 * Class Article
 * @package core\entities\Site\Article
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $post_date
 * @property string $thumb
 * @property boolean $draft
 * @property string $slug
 *
 * @property Translation[] $translations
 * @property Translation $translation
 */
class Article extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%articles}}';
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

    public static function create($thumb, $draft, $post_date, $slug)
    {
        $article = new self();
        $article->thumb = $thumb;
        $article->draft = $draft;
        $article->post_date = $post_date;
        $article->created_at = time();
        $article->slug = $slug;
        return $article;
    }

    public function edit($thumb, $draft, $post_date, $slug)
    {
        $this->thumb = $thumb;
        $this->draft = $draft;
        $this->post_date = $post_date;
        $this->updated_at = time();
        $this->slug = $slug;
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function isDraft()
    {
        return $this->draft == true;
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
        return $this->hasMany(Translation::className(), ['article_id' => 'id']);
    }
    public function getTranslation($language = null)
    {
        $language = ($language)? $language : \Yii::$app->params['defaultLanguage'];
        return $this->hasOne(Translation::className(), ['article_id' => 'id'])->andWhere(['language' => $language]);
    }

    #####
}