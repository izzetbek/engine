<?php

namespace core\forms\manager\Site\Team;

use core\entities\Site\Team\Team;
use core\forms\CompositeForm;
use yii\web\UploadedFile;

/**
 * Class TeamForm
 * @property TranslationsForm[] $translations
 */
class TeamForm extends CompositeForm
{
    public $thumb;
    /** @var  UploadedFile $imageFile */
    public $imageFile;
    public $order;
    public $draft;

    private $_teammate;

    public function internalForms()
    {
        return ['translations'];
    }

    public function __construct(Team $teammate = null, array $config = [])
    {
        $translations = [];
        if ($teammate) {
            $this->thumb = $teammate->thumb;
            $this->order = $teammate->order;
            $this->draft = $teammate->draft;

            foreach (\Yii::$app->params['languages'] as $code => $language) {
                $translations[] = new TranslationsForm($code, $teammate->getTranslation($code)->one());
            }

            $this->_teammate = $teammate;
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
        return $this->_teammate->id;
    }

    public function getName()
    {
        return $this->_teammate->translation->name;
    }

    public function rules()
    {
        return [
            ['order', 'integer'],
            ['draft', 'boolean'],
            [['imageFile'], 'file', 'extensions' => 'png, jpg'],
        ];
    }
}