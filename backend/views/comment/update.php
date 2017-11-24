<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var \core\forms\cabinet\AnswerForm $model
 */
?>
<div class="edit-comment">
    <?php $form = ActiveForm::begin([
        //'action' => \yii\helpers\Url::toRoute(['comment/add', 'id' => $question->id])
    ]); ?>

    <?= $form->field($model, 'content')->textarea(['autofocus' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>