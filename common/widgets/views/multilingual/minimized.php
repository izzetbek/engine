<?php

use common\widgets\MultilingualFormInputs;
use yii\flags\Flags;

/**
 * @var array $fields
 * @var \yii\base\Model $model
 * @var string $language
 */

if ($language == 'en') $language = 'us';
foreach ($fields as $field) {
    $attribute = $field[0];
    $type = $field[1];
    $options = is_array($field[2])? $field[2] : [];
    switch ($type) {
        case MultilingualFormInputs::TYPE_TEXT:
            echo $form->field($model, $attribute, [
                'addon' => ['prepend' => ['content' => Flags::widget([
                    'type' => Flags::SHINY_16,
                    'flag' => $language
                ])]]
            ])->textInput($options)->label(false);
            break;
        case MultilingualFormInputs::TYPE_TEXTAREA:
            echo $form->field($model, $attribute, [
                'addon' => ['prepend' => ['content' => Flags::widget([
                    'flag' => $language
                ])]]
            ])->textarea($options)->label(false);
            break;
        case MultilingualFormInputs::TYPE_EDITOR:
            echo $form->field($model, $attribute, [
                'addon' => ['prepend' => ['content' => Flags::widget([
                    'flag' => $language
                ])]]
            ])->widget(\mihaildev\ckeditor\CKEditor::className(), [
                'editorOptions' => \mihaildev\elfinder\ElFinder::ckeditorOptions('elfinder', [
                    'preset' => 'standard',
                ]),
            ]);
            break;
        default:
            echo $form->field($model, $attribute)->textInput($options);
            break;
    }
}
?>
