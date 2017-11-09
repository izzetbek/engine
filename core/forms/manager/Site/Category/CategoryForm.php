<?php

namespace core\forms\manager\Site\Category;

use core\entities\Site\Category\Category;
use core\forms\CompositeForm;
use core\validators\SlugValidator;
use yii\helpers\ArrayHelper;

/**
 * Class CategoryForm
 * @package core\forms\manager\Site\Category
 * @property TranslationsForm[] $translations
 */
class CategoryForm extends CompositeForm
{
    public $name;
    public $draft = true;
    public $slug;
    public $parentId;
    private $isNewRecord = true;

    private $_category;

    public function internalForms()
    {
        return ['translations'];
    }

    public function __construct(Category $category = null, array $config = [])
    {
        $translations = [];
        if($category) {
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->draft = $category->draft;
            $this->parentId = $category->parent ? $category->parent->id : null;
            $this->_category = $category;
            foreach (\Yii::$app->params['languages'] as $code => $language) {
                $translations[] = new TranslationsForm($code, $category->getTranslation($code)->one());
            }
            $this->isNewRecord = false;
        } else {
            foreach (\Yii::$app->params['languages'] as $code => $language) {
                $translations[] = new TranslationsForm($code);
            }
        }
        $this->translations = $translations;
        parent::__construct($config);
    }

    public function isNewRecord()
    {
        return $this->isNewRecord === true;
    }

    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['parentId', 'draft'], 'integer'],
            ['slug', SlugValidator::class],
            [['name', 'slug'], 'unique', 'targetClass' => Category::class, 'filter' => $this->_category ? ['<>', 'id', $this->_category->id] : null]
        ];
    }

    public function parentCategoriesList()
    {
        return ArrayHelper::map(Category::find()->orderBy('lft')->asArray()->all(), 'id', function (array $category) {
            return ($category['depth'] > 1 ? str_repeat('-- ', $category['depth'] - 1) . ' ' : '') . $category['name'];
        });
    }

    public function getName()
    {
        return $this->_category->name;
    }

    public function getId()
    {
        return $this->_category->id;
    }
}