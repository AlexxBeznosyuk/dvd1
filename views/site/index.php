<?php
use yii\db\ActiveRecord;
use yii\widgets\LinkPager;
use yii\web\UrlManager;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Types;

/* @var $this yii\web\View */

$this->title = 'DVD Store';
?>
<div class="site-index">

    <div class="jumbotron">
        <?php $form = ActiveForm::begin(['id' => 'filter-form','options' => ['class' => 'filter-form']]); ?>
        <?= Html::radioList('type', [Yii::$app->session['type']], ArrayHelper::map($types, 'id', 'name'), ['class' => 'filter-form__radio-type']) ?>
        <?= $form->field($filterSearch, 'country')->label('')
                 ->dropdownList(ArrayHelper::map($countries, 'id', 'name'),
                    ['options'=> [Yii::$app->session['country'] => ['Selected' => true]]]);?>
        <?= $form->field($filterSearch, 'genre')->label('')
                 ->dropdownList(ArrayHelper::map($genres, 'id', 'name'),
                    ['options'=> [Yii::$app->session['genre'] => ['Selected' => true]]]);?>
        <?= Html::label('Год:', 'year', ['class' => 'filter-form__year']) ?>
        <?= Html::radioList('year', [Yii::$app->session['year']], [ 'up' => "up", 'down' => 'down'], ['class' => 'filter-form__radio']) ?>
        <?= Html::label('Pейтинг:', 'rating', ['class' => 'filter-form__rating']) ?>
        <?= Html::radioList('rating', [Yii::$app->session['rating']], [ 'up' => 'up', 'down' => 'down'], ['class' => 'filter-form__radio']) ?>
        <div class="form-group">
            <?= Html::submitButton('Применить..', ['class' => 'btn-success btn-sm', 'name' => 'save-button']) ?>
            <?= Html::submitButton('Сбросить', ['class' => 'reset btn-danger btn-sm', 'name' => 'reset-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <div class="body-content">
        <?php 
          if(!$items){
            echo "По вашему запросу ничего нет!!";
          }else{
            foreach($items as $item){
        ?>
            <div class="pre-item">
                <h3 class="pre-item__title"><?=$item->title?></h3>
                <div class="pre-item__type">Категория: <?=$item->type?> </div>
                <div class="pre-item__rating">Рейтинг: <img style="width:<?=$item->rating * 15?>px;"> </div>
                <div class="pre-item__country">Страна: <?=$item->country?> </div>
                <div class="pre-item__year">Год: ( <?=$item->year?> )</div>
                <div class="pre-item__comment">Комментарии: <?=count($item->rewiews)?></div>
                
                <a class="pre-item__link" href="<?=Yii::$app->urlManager->createUrl(['/site/detail', 'itemid' => "$item->id"])?>"><img class="pre-item__image" src="<?= $item->image ?>"></a>
            </div>
        <?php        
          }
        }
        ?>
    </div>
    <div class="pagin">
        <?= LinkPager::widget([
            'pagination' => $pagination,
            'firstPageLabel' => 'В начало',
            'lastPageLabel' => 'В конец',
            'prevPageLabel' => '&laquo;'
        ])
        ?>
    </div>
</div>

