<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \core\forms\manager\Site\Glossary\GlossaryForm */

$this->title = 'Update Glossary: ' . $model->getTitle();
$this->params['breadcrumbs'][] = ['label' => 'Glossaries', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->getTitle(), 'url' => ['view', 'id' => $model->getId()]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="glossary-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
