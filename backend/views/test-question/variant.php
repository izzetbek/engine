<?php
/**
 * @var \core\forms\manager\OnlineTest\Variant\VariantsForm $model
 */
?>
<div class="box" id="example-variant">
    <div class="box-body">
        <? $form = \yii\widgets\ActiveForm::begin(); ?>
        <table width="100%">
            <tr>
                <td width="90%">
                    <?= $form->field($model, 'translations', ['options' => ['class' => 'nav-tabs-custom']])->widget(\common\widgets\MultilingualFormInputs::className(), [
                        'fields' => [
                            ['content', 'text']
                        ],
                        'minimized' => true,
                    ])->label(false) ?>
                </td>
                <td width="10%" valign="middle" align="center">
                    <?= $form->field($model, 'correct')->checkbox(['label' => null, 'class' => 'is_correct'])->label(false); ?>
                </td>
            </tr>
        </table>
        <? \yii\widgets\ActiveForm::end() ?>
    </div>
</div>