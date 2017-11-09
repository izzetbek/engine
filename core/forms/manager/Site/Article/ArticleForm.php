<?php

namespace core\forms\manager\Site\Article;

use core\entities\Site\Article\Article;
use core\forms\CompositeForm;
use yii\web\UploadedFile;
use core\validators\SlugValidator;

/**
 * @property TranslationsForm[] $translations
 */
class ArticleForm extends CompositeForm
{
    public $draft = true;
    public $slug;
    public $thumb;
    /** @var  UploadedFile $imageFile */
    public $imageFile;
    public $postDate;
    public $isNewRecord = true;

    private $_article;

    public function internalForms()
    {
        return ['translations'];
    }

    public function __construct(Article $article = null, array $config = [])
    {
        $translations = [];
        if($article) {
            $this->thumb = $article->thumb;
            $this->slug = $article->slug;
            $this->draft = $article->draft;
            $this->postDate = \Yii::$app->formatter->asDate($article->post_date, 'php:d-m-Y');
            $this->_article = $article;
            foreach (\Yii::$app->params['languages'] as $code => $language) {
                $translations[] = new TranslationsForm($code, $article->getTranslation($code)->one());
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

    public function rules()
    {
        return [
            ['slug', 'required'],
            ['slug', 'string', 'max' => 255],
            ['slug', SlugValidator::class],
            ['imageFile', 'file', 'extensions' => 'png, jpg'],
            ['postDate', 'date', 'format' => 'php:d-m-Y'],
            ['slug', 'unique', 'targetClass' => Article::class, 'filter' => $this->_article ? ['<>', 'id', $this->_article->id] : null]
        ];
    }

    public function getName()
    {
        return $this->_article->translation->title;
    }

    public function getId()
    {
        return $this->_article->id;
    }
}