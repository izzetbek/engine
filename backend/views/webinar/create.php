<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\entities\Webinar\Webinar */

$this->title = 'Create Webinar';
$this->params['breadcrumbs'][] = ['label' => 'Webinars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="webinar-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
