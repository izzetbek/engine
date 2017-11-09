<?php

/** @var $this yii\web\View */
/** @var $webinar \core\entities\Webinar\Webinar  */

$this->title = $webinar->translation->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-view">
    <div class="body-heading">
        <h3><?= $webinar->translation->title ?></h3>
    </div>
    <div class="body-content">
        <div class="row"><?= $webinar->translation->cabinet_description ?></div>
    </div>
</div>
