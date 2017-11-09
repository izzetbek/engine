<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model core\entities\Site\HRTemplate\Template */

$this->title = 'Create Template';
$this->params['breadcrumbs'][] = ['label' => 'Templates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
