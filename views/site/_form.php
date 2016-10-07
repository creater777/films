<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use app\models\Directors;

/* @var $this yii\web\View */
/* @var $model app\models\Films */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin([
         'options' => ['enctype'=>'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dateInner')->widget(MaskedInput::className(), ['mask' => '99.99.9999']) ?>

    <?=$form->field($model, 'preview')->fileInput() ?>

    <?=$form->field($model, 'director_id')->listBox(Directors::getAll()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
