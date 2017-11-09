<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\entities\Site\SuccessStory\SuccessStory */

$this->title = 'Create Success Story';
$this->params['breadcrumbs'][] = ['label' => 'Success Stories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="success-story-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
