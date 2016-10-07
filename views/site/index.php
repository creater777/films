<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\User;
use app\models\Films;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FilmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Фильмы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?php
        if (Yii::$app->user->can(User::PERMISSION_EDITFILMS)){
            echo Html::a('Создать', ['create'], ['class' => 'btn btn-success']);
        }
    ?>
    </p>
    <?php 
        $items = ['2' => 2, '20' => 20, '40' => 40, '60' => 60];
        $itemIndex = Films::getFilmsInPage();
        echo 'Отображать по ' . Html::dropDownList('filmsInPage', $itemIndex, $items) . ' записей';
 //       echo $this->render('_search', ['model' => $searchModel]);

        Pjax::begin(['id' => 'films']);
            $columns = [
                'dateInner',
                'name',
                'director.fullName',
            ];
            if (Yii::$app->user->can(User::PERMISSION_EDITFILMS)){
                $template = '{update} {view} {delete}';
            } else{
                $template = '{view}';
            }
            if (isset($template)){
                $columns[] = [
                    'class' => 'yii\grid\ActionColumn',
                    'headerOptions' => ['width' => '80'],
                    'template' => $template,    
                ];
            }
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'showHeader' => false,
                'columns' => $columns,
            ]); 
        Pjax::end();   
    ?>
</div>
