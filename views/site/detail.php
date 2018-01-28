<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Rewiews */
/* @var $form ActiveForm */
?>
<div class="item-block">
  <h3 class="item-block__title"><?=$item->title?> ( <?=$item->year?> )</h3>
  <img class="item-block__image" src="<?= $item->image ?>"> 
  <div class="pre-item__rating">Рейтинг: <img style="width:<?=$item->rating * 15?>px;"> </div>
  <div class="item-block__prod">Страна: <?=$item->country?></div>
  <p class="item-block__desc"><?=$item->description?></p>  
  <div class="clear"></div>          
</div>
<hr>
<iframe width="800" height="500" src="https://www.youtube.com/embed/<?=$item->trailer?>?rel=0" frameborder="0" 
				allow="autoplay; encrypted-media" allowfullscreen></iframe>
<div class="site-detail">
		<?php if (Yii::$app->session->hasFlash('AddRewiew')){ ?>
        		<div class="alert alert-success">
           	 Новый комментарий добавлен!
       			</div>
    <?php } ?>
		<?= Html::beginForm(['site/detail', 'itemid' => $item->id], 'post', ['class' => 'form-rating']) ?>
		<?= Html::radioList('rating', [] , [ '1'=> '1','2'=> '2','3'=> '3','4'=> '4','5'=> '5'], ['class' => 'form-rating__radio']) ?>
		<?= Html::submitButton('Оценить', ['class' => 'btn btn-primary btn-sm']) ?>
		<?= Html::endForm() ?>

    <?php $form = ActiveForm::begin(); ?>
    		<?= $form->field($model, 'username')->textInput()->label('Ваше имя'); ?>
    		<?= $form->field($model, 'msg')->textarea(['rows' => 6])->label('Комментарий'); ?>
    		
        <div class="form-group">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary btn-sm']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>

<div class="rew">
		<?php
			foreach($item->rewiews as $rewiew){ ?>
				<div class="rew-comment">
					<div class="delete-comment">
						<?php 
						if(Yii::$app->session->get('__id') == 100)
							echo '<br><a href="'.Yii::$app->urlManager->createUrl(["site/detail", 'itemid' => $item->id, 'del' => $rewiew->id ]).'">X</a>';?>
					</div>
					<div class="rew-comment__name"><?=$rewiew->username?></div>
					<div class="rew-comment__date"><?=$rewiew->date?></div>
					<div class="rew-comment__text"><?=$rewiew->msg?></div>
				</div>

		<?php	}
		?>
</div>
