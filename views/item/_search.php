<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="items-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'genreid') ?>

    <?= $form->field($model, 'typeid') ?>

    <?= $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'countryid') ?>

    <?php // echo $form->field($model, 'rating') ?>

    <?php // echo $form->field($model, 'img') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'trailer') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
