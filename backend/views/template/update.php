<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \core\forms\manager\Site\HRTemplate\TemplateForm */

$this->title = 'Update Template: ' . $model->getName();
$this->params['breadcrumbs'][] = ['label' => 'Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->getName(), 'url' => ['view', 'id' => $model->getId()]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="template-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
