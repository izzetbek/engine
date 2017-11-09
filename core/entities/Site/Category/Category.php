<?php

namespace core\entities\Site\Category;

use core\entities\Meta;
use paulzi\nestedsets\NestedSetsBehavior;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use core\entities\Site\queries\CategoryQuery;
use yii\db\ActiveRecord;

/**
 * Class Category
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property integer $draft
 *
 * @property Translation[] $translations
 * @property Category $parent
 * @mixin NestedSetsBehavior
 */
class Category extends ActiveRecord
{
    public static function create($name, $slug, $draft)
    {
        $category = new static();
        $category->name = $name;
        $category->slug = $slug;
        $category->draft = $draft;

        return $category;
    }

    public function edit($name, $slug, $draft)
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->draft = $draft;
    }

    public static function tableName()
    {
        return '{{%site_categories}}';
    }

    public function behaviors()
    {
        return [
            NestedSetsBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['translations'],
            ],
        ];
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

    public static function find()
    {
        return new CategoryQuery(static::class);
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
        return $this->hasMany(Translation::className(), ['category_id' => 'id']);
    }
    public function getTranslation($language = null)
    {
        $language = ($language)? $language : \Yii::$app->params['defaultLanguage'];
        return $this->hasOne(Translation::className(), ['category_id' => 'id'])->andWhere(['language' => $language]);
    }

    #####
}