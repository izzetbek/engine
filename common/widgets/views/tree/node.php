<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use lo\widgets\modal\ModalAjax;

/** @var array $node */
/** @var int $level */
/** @var \core\forms\cabinet\AnswerForm $model */

$width = 100 - 3 * $level;
$panelClass = ($node['user']['role'] == 'admin') ? 'info' : 'default';
?>
<div class="panel panel-<?= $panelClass ?> pull-right" style="width: <?= $width ?>%">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-3 col-md-1">
                <img src="<?= Yii::getAlias('@frontendUpload/users/' . $node['user']['thumb']) ?>" class="img-thumbnail">
            </div>
            <div class="col-xs-6 col-sm-9 col-md-10">
                <p><b><?= $node['user']['username'] ?></b></p>
                <small><?= Yii::$app->formatter->asDate($node['answer_date']) ?></small>
            </div>
            <? if ($node['user']['id'] == Yii::$app->user->id): ?>
            <div class="col-xs-3 col-sm-1 text-right">
                <a href="<?= Url::to(['comment/update', 'id' => $node['id']]) ?>" class="glyphicon glyphicon-pencil stripped update-comment"></a>
                <a href="<?= Url::to(['comment/delete', 'id' => $node['id']]) ?>" class="glyphicon glyphicon-trash"></a>
                <?= ModalAjax::widget([
                    'id' => 'updateComment',
                    'selector' => '.update-comment',
                    'ajaxSubmit' => 0,
                ]) ?>
            </div>
            <? endif; ?>
        </div>
    </div>
    <div class="panel-body">
        <?= $node['content'] ?>
    </div>
    <div class="panel-footer">
        <a href="#" class="attachComment">Comment</a>
        <div class="attach-comment hidden">
            <?php $form = ActiveForm::begin([
                'action' => Url::toRoute(['comment/attach', 'id' => $node['id']])
            ]); ?>

            <?= $form->field($model, 'content')->textarea()->label(false) ?>

            <?= Html::submitButton('Comment', ['class' => 'btn btn-success']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<br clear="both">