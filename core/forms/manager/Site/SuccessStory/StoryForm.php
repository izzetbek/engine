<?php

namespace core\forms\manager\Site\SuccessStory;

use core\entities\Site\SuccessStory\SuccessStory;
use yii\web\UploadedFile;
use core\forms\CompositeForm;

/**
 * Class StoryForm
 * @property TranslationsForm[] $translations
 */
class StoryForm extends CompositeForm
{
    public $thumb;
    /** @var  UploadedFile $imageFile */
    public $imageFile;
    public $company;
    public $order;
    public $draft;
    public $isNewRecord = true;

    private $_story;

    public function internalForms()
    {
        return ['translations'];
    }

    public function __construct(SuccessStory $story = null, array $config = [])
    {
        $translations = [];
        if ($story) {
            $this->thumb = $story->thumb;
            $this->company = $story->company;
            $this->order = $story->order;
            $this->draft = $story->draft;
            $this->isNewRecord = false;

            foreach (\Yii::$app->params['languages'] as $code => $language) {
                $translations[] = new TranslationsForm($code, $story->getTranslation($code)->one());
            }

            $this->_story = $story;
        } else {
            foreach (\Yii::$app->params['languages'] as $code => $language) {
                $translations[] = new TranslationsForm($code);
            }
        }
        $this->translations = $translations;
        parent::__construct($config);
    }

    public function getId()
    {
        return $this->_story->id;
    }

    public function getName()
    {
        return $this->_story->translation->name;
    }

    public function rules()
    {
        return [
            ['company', 'string', 'max' => 255],
            ['order', 'integer'],
            ['draft', 'boolean'],
            [['imageFile'], 'file', 'extensions' => 'png, jpg'],
        ];
    }
}