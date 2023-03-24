<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AnnouncedPuResults $model */

$this->title = 'Store Announced Pu Results';
$this->params['breadcrumbs'][] = ['label' => 'LGA Results', 'url' => ['lga-result']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="announced-pu-results-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>