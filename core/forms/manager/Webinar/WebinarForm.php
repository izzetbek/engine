<?php

namespace core\forms\manager\Webinar;

use core\entities\Webinar\Webinar;
use core\forms\CompositeForm;
use yii\web\UploadedFile;

/**
 * Class WebinarForm
 * @package core\forms\manager\Site\Category
 * @property TranslationsForm[] $translations
 */
class WebinarForm extends CompositeForm
{
    public $thumb;
    /** @var  UploadedFile $imageFile */
    public $imageFile;
    public $price;
    public $beginDate;
    public $status;
    public $isNewRecord = true;

    private $_webinar;

    public function internalForms()
    {
        return ['translations'];
    }

    public function __construct(Webinar $webinar = null, array $config = [])
    {
        $translations = [];
        if($webinar) {
            $this->thumb = $webinar->thumb;
            $this->price = $webinar->price;
            $this->beginDate = $webinar->beginDate;
            $this->status = $webinar->status;
            $this->isNewRecord = false;
            $this->_webinar = $webinar;
            foreach (\Yii::$app->params['languages'] as $code => $language) {
                $translations[] = new TranslationsForm($code, $webinar->getTranslation($code)->one());
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
            [['price', 'beginDate'], 'required'],
            ['imageFile', 'file', 'extensions' => 'png, jpg'],
            ['price', 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            ['status', 'number']
        ];
    }

    public function getId()
    {
        return $this->_webinar->id;
    }

    public function getTitle()
    {
        return $this->_webinar->translation->title;
    }
}