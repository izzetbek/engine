<?php

namespace core\forms\manager\OnlineTest\Question;

use core\entities\OnlineTest\Question\Question;
use core\forms\CompositeForm;
use core\forms\manager\OnlineTest\Variant\VariantsForm;

/**
 * Class OnlineTestForm
 *
 * @property TranslationsForm[] $translations
 * @property VariantsForm[] $variants
 */
class QuestionForm extends CompositeForm
{
    public $order;
    public $testId;

    private $_question;

    public function __construct(Question $question = null, $additional = false, array $config = [])
    {
        $translations = [];
        if ($question) {
            $variants = $question->variants;
            $this->order = $question->order;
            $this->testId = $question->test_id;

            $variantForms = [];

            foreach (\Yii::$app->params['languages'] as $code => $language) {
                $translations[] = new TranslationsForm($code, $question->getTranslation($code)->one());
            }
            $i = 0;
            if (!empty($variants)) {
                foreach ($variants as $variant) {
                    $variantForms[] = new VariantsForm($i, $variant);
                    $i++;
                }
                if ($additional) {
                    $variantForms[] = new VariantsForm($i);
                }
            } else {
                $variantForms[] = new VariantsForm($i);
            }
            $this->_question = $question;
            $this->variants = $variantForms;
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
            ['testId', 'required'],
            [['testId', 'order'], 'integer']
        ];
    }

    public function internalForms()
    {
        return ['translations', 'variants'];
    }

    public function getId()
    {
        return $this->_question->id;
    }
}