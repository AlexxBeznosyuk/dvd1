<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Добавить фильм';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="manager">
<h2><?= Html::encode($this->title) ?></h2>
<div class="dobav">
<?= Html::beginForm(['site/sitemanager', 'id' => $id], 'post')?>

<?= Html::input('text', 'country') ?>
<?= Html::submitButton('Добавить страну', ['class' => 'submit']) ?>

<?= Html::input('text', 'genre') ?>
<?= Html::submitButton('Добавить жанр', ['class' => 'submit']) ?>

<?= Html::input('text', 'type') ?>
<?= Html::submitButton('Добавить тип', ['class' => 'submit']) ?>
<?php 
  if (Yii::$app->session->hasFlash('successAdd')){
    echo "Запись успешно добавлена!!";
  }
?>
<?= Html::endForm() ?>

</div>
<?php if (Yii::$app->session->hasFlash('Successful_save')): ?>

        <div class="alert alert-success">
            Новый фильм успешно добавлен в базу!
        </div>
        <?php echo '<br><a href="'.Yii::$app->urlManager->createUrl(["site/sitemanager"]).'">Добавить ещё!!!</a>';?>

<?php else: ?>

		<div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']], 
            																['id' => 'save-form']); ?>
              <?= $form->field($model, 'title')->textInput(['autofocus' => true])->label('Название фильма') ?>
              <?= $form->field($model, 'genre')->dropDownList(ArrayHelper::map($genres,'id','name'))->label('Жанр') ?>
              <?= $form->field($model, 'type')->dropDownList(ArrayHelper::map($types,'id','name'))->label('Тип')?>
              <?= $form->field($model, 'year')->label('Год выпуска') ?>
              <?= $form->field($model, 'country')->dropDownList(ArrayHelper::map($countries,'id','name'))->label('Страна') ?>
              <?= $form->field($model, 'img')->fileInput()->label('Картинка') ?>
              <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание фильма') ?>
              <?= $form->field($model, 'trailer')->label('Имя трейлера на Youtube') ?>
              <div class="form-group">
                  <?= Html::submitButton('Сохранить..', ['class' => 'btn btn-primary', 'name' => 'save-button']) ?>
              </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

<?php endif; ?>

</div>



