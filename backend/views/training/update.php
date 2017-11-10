<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model core\entities\Training\Training */

$this->title = 'Update Training: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Trainings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="training-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
