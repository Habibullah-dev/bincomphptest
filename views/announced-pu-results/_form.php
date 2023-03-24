<?php

use app\models\Party;
use yii\helpers\Html;
use app\models\PollingUnit;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\ActiveForm;


/** @var yii\web\View $this */
/** @var app\models\AnnouncedPuResults $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="announced-pu-results-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'polling_unit_uniqueid')->dropDownList(ArrayHelper::map(PollingUnit::find()->all(), 'uniqueid', 'polling_unit_name'), [
        'prompt' => 'SELECT POLLING UNIT',
    ])
    ?>

    <?= $form->field($model, 'party_abbreviation')->dropDownList(ArrayHelper::map(Party::find()->all(), 'partyid', 'partyname'), ['prompt' => 'SELECT PARTY']) ?>

    <?= $form->field($model, 'party_score')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'entered_by_user')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Store Result', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>