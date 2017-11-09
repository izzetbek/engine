<?php

namespace core\forms\manager\OnlineTest\Test;

use core\entities\OnlineTest\Test\OnlineTest;
use core\forms\CompositeForm;
use yii\web\UploadedFile;

/**
 * Class OnlineTestForm
 * @property TranslationsForm[] $translations
 */
class OnlineTestForm extends CompositeForm
{
    public $thumb;
    /** @var  UploadedFile $imageFile */
    public $imageFile;
    public $price;
    public $status;
    public $isNewRecord = true;

    private $_test;

    public function internalForms()
    {
        return ['translations'];
    }

    public function __construct(OnlineTest $test = null, array $config = [])
    {
        $translations = [];
        if ($test) {
            $this->thumb = $test->thumb;
            $this->price = $test->price;
            $this->status = $test->status;

            foreach (\Yii::$app->params['languages'] as $code => $language) {
                $translations[] = new TranslationsForm($code, $test->getTranslation($code)->one());
            }

            $this->_test = $test;
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
        return $this->_test->id;
    }

    public function getTitle()
    {
        return $this->_test->translation->title;
    }

    public function rules()
    {
        return [
            ['status', 'boolean'],
            ['price', 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            [['imageFile'], 'file', 'extensions' => 'png, jpg'],
        ];
    }
}