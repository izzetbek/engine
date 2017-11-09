<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \core\forms\manager\Webinar\WebinarForm */

$this->title = 'Update Webinar: ' . $model->getTitle();
$this->params['breadcrumbs'][] = ['label' => 'Webinars', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->getTitle(), 'url' => ['view', 'id' => $model->getId()]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="webinar-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
