<?php

namespace common\widgets;

use core\forms\manager\Site\Category\CategoryForm;
use yii\bootstrap\Tabs;
use yii\widgets\InputWidget;

/**
 * @property CategoryForm $model
 */
class MultilingualFormInputs extends InputWidget
{
    public $fields = [];

    public $model;

    public $form;

    public $minimized = false;

    private $items;

    const TYPE_TEXT = 'text';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_EDITOR = 'editor';

    public function init()
    {
        parent::init();
        $this->form = $this->field->form;

        $textInputsCount = 0;
        foreach ($this->fields as $field) {
            if ($field[1] == self::TYPE_TEXT) {
                $textInputsCount++;
            }
        }
        $formGroupClass = 'col-md-4';
        if ($textInputsCount <= 4) {
            $formGroupClass = 'col-md-' . (12 / $textInputsCount);
        }

        foreach ($this->model->translations as $content) {
            if ($this->minimized) {
                $item = $this->render('multilingual/minimized', [
                    'model' => $content,
                    'form' => $this->form,
                    'fields' => $this->fields,
                    'language' => $content->language,
                    'formGroupClass' => $formGroupClass,
                ]);
                $this->items .= $item;
            } else {
                $item = [
                    'label' => \Yii::$app->params['languages'][$content->language],
                    'content' => $this->render('multilingual/_fields', [
                        'model' => $content,
                        'form' => $this->form,
                        'fields' => $this->fields,
                        'formGroupClass' => $formGroupClass,
                    ]),
                    'active' => ($content->language == \Yii::$app->params['defaultLanguage'])? true : false
                ];
                $this->items[] = $item;
            }
        }
    }

    public function run()
    {
        if ($this->minimized) {
            return $this->items;
        }
        return Tabs::widget([
            'items' => $this->items,
        ]);
    }
}