<?php

use app\models\AnnouncedPuResults;
use app\models\Party;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\AnnouncedPuResultsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Announced Pu Results';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$data = [];

$providers = $dataProvider->getModels();

foreach ($providers  as $model) {
    if (!isset($data[$model->polling_unit_uniqueid])) {
        $data[$model->polling_unit_uniqueid] = [$model];
    } else {
        $data[$model->polling_unit_uniqueid][] = $model;
    };
}

?>

<div class="announced-pu-results-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <div class="polling-container d-flex flex-wrap w_100">
        <?php foreach ($data as $key => $datum) { ?>

        <div class="card m-4" style="width: 35rem;">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title"><?= $datum[0]->pollingUnit->polling_unit_name ?></h5>
                        <h6>Unit Id No <?= $key  ?></h6>
                        <p></p>
                        <p> <span class="fw-bold">Ward:</span> <?= $datum[0]->pollingUnit->polling_unit_name ?>
                        </p>
                        <p><span class="fw-bold">LGA: </span></p>
                        <p class="card-text"><span class="fw-bold">Description:
                            </span><?= $datum[0]->pollingUnit->polling_unit_description ?> .</p>
                        <a href="#" class="btn btn-primary">Show Details</a>
                    </div>
                    <div>

                        <ol class="list-group list-group-numbered">
                            <?php foreach ($datum as $model) { ?>
                            <li class="list-group-item d-flex justify-content-between align-items-start bg-light">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold"><?= $model->party_abbreviation ?></div>
                                </div>
                                <span class="badge bg-primary rounded-pill"><?= $model->party_score ?></span>
                            </li>
                            <?php  } ?>
                        </ol>
                    </div>

                </div>

            </div>
        </div>

        <?php  } ?>

    </div>




</div>