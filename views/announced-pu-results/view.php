<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\AnnouncedPuResults $model */

$this->title = $model->result_id;
$this->params['breadcrumbs'][] = ['label' => 'Announced Pu Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="announced-pu-results-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'result_id' => $model->result_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'result_id' => $model->result_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'result_id',
            'polling_unit_uniqueid',
            'party_abbreviation',
            'party_score',
            'entered_by_user',
            'date_entered',
            'user_ip_address',
        ],
    ]) ?>

</div>
