<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Event */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'События', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="event-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' =>'Вы уверины что хотите удалить событие?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php
    if(!empty($model->picture)){
        $ht = 'http';
        if (isset($_SERVER['HTTPS'])) $ht =' https';
        if(stristr($model->picture,'upload/event/')){
            $previv = $ht.'://'.$_SERVER['SERVER_NAME'].'/'.$model->picture;
        } else  $previv = $model->picture;
    }
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'event_time',
            'description:ntext',
            [
                'label' => 'Адреса события',
                'value' => implode('; ', ArrayHelper::map($model->addresses, 'id', 'st_addr')),
            ],
            [
                'label' => 'Задействованные в событии организации',
                'value' => implode('; ', ArrayHelper::map($model->organisation, 'id', 'name')),
            ],
            'picture',
            [
                'label' => 'Превью картинки',
                'value' =>  $previv,
                'format' => ['image',['width'=>'230','class'=>'postImg']],
            ]
        ],
    ]) ?>


</div>
