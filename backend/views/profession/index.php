<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProfessionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Профессии';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profession-index">

    <h1><?= Html::encode($this->title) ?></h1>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать Профессию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            //'short_desc',
            //'description:ntext',
            //'img',
            //'low_salary',
            //'high_salary',
            //'created_at',
            'deleted_at',
            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
