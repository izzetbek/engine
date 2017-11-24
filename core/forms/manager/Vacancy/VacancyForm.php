<?php

namespace core\forms\manager\Vacancy;

use core\entities\Vacancy\Vacancy;
use core\forms\CompositeForm;

/**
 * @property TranslationsForm[] $translations
 */
class VacancyForm extends CompositeForm
{
    public $startDate;
    public $endDate;
    public $userId;
    public $draft;
    public $isNewRecord = true;

    private $_vacancy;

    public function internalForms()
    {
        return ['translations'];
    }

    public function __construct(Vacancy $vacancy = null, array $config = [])
    {
        $translations = [];
        if ($vacancy) {
            $this->userId = $vacancy->user_id;
            $this->startDate = \Yii::$app->formatter->asDate($vacancy->start_date, 'php:d-m-Y');
            $this->endDate = \Yii::$app->formatter->asDate($vacancy->end_date, 'php:d-m-Y');
            $this->draft = $vacancy->draft;
            $this->isNewRecord = false;
            $this->_vacancy = $vacancy;
            foreach (\Yii::$app->params['languages'] as $code => $language) {
                $translations[] = new TranslationsForm($code, $vacancy->getTranslation($code)->one());
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
            ['userId', 'required'],
            ['userId', 'integer'],
            ['draft', 'boolean'],
            [['startDate', 'endDate'], 'date', 'format' => 'php:d-m-Y'],
        ];
    }
}