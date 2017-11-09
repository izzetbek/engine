<?php

use \common\widgets\MultilingualFormInputs;

/* @var $form \yii\widgets\ActiveForm */
/* @var $model \core\forms\CompositeForm */
/* @var $fields array */
/* @var \core\entities\Meta $meta */
/* @var string $formGroupClass */

?>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Content</h3>
    </div>
    <div class="box-body">
        <?php

        foreach ($fields as $field) {
            $attribute = $field[0];
            $type = $field[1];
            $options = is_array($field[2])? $field[2] : [];
            switch ($type) {
                case MultilingualFormInputs::TYPE_TEXT:
                    echo $form->field($model, $attribute, ['options' => ['class' => 'form-group ' . $formGroupClass]])->textInput($options);
                    break;
                case MultilingualFormInputs::TYPE_TEXTAREA:
                    echo $form->field($model, $attribute)->textarea($options);
                    break;
                case MultilingualFormInputs::TYPE_EDITOR:
                    echo $form->field($model, $attribute)->widget(\mihaildev\ckeditor\CKEditor::className(), [
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
    </div>
</div>
<? if ($model->hasMethod('internalForms') && in_array('meta', $model->internalForms())): ?>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Meta</h3>
        </div>
        <div class="box-body">
            <?= $form->field($model->meta, 'title')->textInput() ?>
            <?= $form->field($model->meta, 'keywords')->textarea() ?>
            <?= $form->field($model->meta, 'description')->textarea() ?>
        </div>
    </div>
<? endif; ?>