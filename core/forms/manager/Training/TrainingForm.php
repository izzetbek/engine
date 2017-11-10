<?php

namespace core\forms\manager\Training;

use core\entities\Training\Training;
use core\forms\CompositeForm;
use yii\web\UploadedFile;

/**
 * @property TranslationsForm[] $translations
 */
class TrainingForm extends CompositeForm
{
    public $thumb;
    /** @var  UploadedFile $imageFile */
    public $imageFile;
    public $beginDate;
    public $price;
    public $draft;
    public $isNewRecord = true;

    private $_training;

    public function internalForms()
    {
        return ['translations'];
    }

    public function __construct(Training $training = null, array $config = [])
    {
        $translations = [];
        if ($training) {
            $this->thumb = $training->thumb;
            $this->price = $training->price;
            $this->beginDate = \Yii::$app->formatter->asDate($training->begin_date, 'php:d-m-Y');
            $this->isNewRecord = false;
            $this->_training = $training;
            foreach (\Yii::$app->params['languages'] as $code => $language) {
                $translations[] = new TranslationsForm($code, $training->getTranslation($code)->one());
            }
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
            ['price', 'required'],
            ['price', 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            ['draft', 'boolean'],
            ['imageFile', 'file', 'extensions' => 'png, jpg'],
            ['beginDate', 'date', 'format' => 'php:d-m-Y'],
        ];
    }

    public function getId()
    {
        return $this->_training->id;
    }

    public function getTitle()
    {
        return $this->_training->translation->title;
    }
}