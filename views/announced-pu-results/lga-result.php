<?php

use yii\helpers\Url;
use app\models\Party;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\ActiveForm;
use app\models\AnnouncedPuResults;
use app\models\Lga;

/** @var yii\web\View $this */
/** @var app\models\AnnouncedPuResultsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'LGA Results';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="lga-results-index">

    <?php
    $list =  ArrayHelper::map(Lga::find()->all(), 'lga_id', 'lga_name');
    $form = ActiveForm::begin([
        'action' => ['lga-result'],
        'method' => 'get',
    ]);

    $form->field($searchModel, 'lga_id')->dropDownList(
        $list,
        [
            'prompt' => 'SELECT All LGA',
            'onchange' => '$(this).submit()'
        ],
        // options
    )->label(false);

    ActiveForm::end();
    ?>

</div>



<div class="announced-pu-results-index">

    <div class="d-flex justify-content-between mx-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="" style="margin-right: 70px;">
            <?= Html::a('Store Announced Pu Results', ['create'], ['class' => 'btn btn-success ms-auto']) ?>
        </div>
    </div>


    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <div class="polling-container d-flex flex-wrap w_100">
        <?php foreach ($data as $key => $datum) { ?>

            <div class="card m-4" style="width: 35rem;">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title"><?= $datum[0]->pollingUnitLga->lga_name ?> LGA</h5>
                            <p> <span class="fw-bold">LGA ID: </span><?= $datum[0]->pollingUnitLga->lga_id ?>
                            </p>
                            <p> <span class="fw-bold">Name: </span><?= $datum[0]->pollingUnitLga->lga_description ?>
                            </p>
                            <p><span class="fw-bold">State:<?= $datum[0]->pollingUnitLga->state->state_name ?> </span></p>
                            <p class="card-text"><span class="fw-bold">Description:
                                </span><?= $datum[0]->pollingUnit->polling_unit_description ?> .</p>
                            <a href="#" class="btn btn-primary">Show Details</a>
                        </div>
                        <div>
                            <ol class="list-group list-group-numbered">
                                <?php foreach ($datum as $model) { ?>
                                    <?php
                                    $party = $model->party_abbreviation;
                                    $party_score = $model->party_score;

                                    if (!isset($parties[$party])) {
                                        $parties[$party] = $party_score;
                                    } else {
                                        $parties[$party] += $party_score;
                                    };

                                    ?>

                                <?php  } ?>
                                <?php foreach ($parties as $key => $value) { ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-start bg-light">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold"><?= $key ?></div>
                                        </div>
                                        <span class="badge bg-primary rounded-pill"><?= $value ?></span>
                                    </li>

                                <?php }
                                $parties = [];
                                ?>

                            </ol>

                        </div>

                    </div>

                </div>
            </div>

        <?php  } ?>

    </div>

    <?php if (empty($providers)) { ?>
        <div class="card m-4 border border-warning" style="width: 35rem;">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <p>This LGA Result Is Not Announced <br> Choose Another LGA</p>
                </div>
            </div>
        </div>
    <?php } ?>


</div>