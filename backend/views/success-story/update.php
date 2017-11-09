<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \core\forms\manager\Site\SuccessStory\StoryForm */

$this->title = 'Update Success Story: ' . $model->getName();
$this->params['breadcrumbs'][] = ['label' => 'Success Stories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->getName(), 'url' => ['view', 'id' => $model->getId()]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="success-story-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
