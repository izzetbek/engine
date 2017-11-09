<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model core\entities\Config */

$this->title = 'Update Config: ' . $model->param;
$this->params['breadcrumbs'][] = ['label' => 'Configs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->param, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="config-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
