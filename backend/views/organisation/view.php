<?php

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;


//use backend\models\Organisation;
//use backend\models\Type;
//use backend\models\Profession;
//use backend\models\Address;
/* @var $this yii\web\View */
/* @var $model backend\models\Organisation */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="organisation-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' =>'Вы уверины что хотите удалить организацию?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php
        if(!empty($model->img)){
            $ht = 'http';
            if (isset($_SERVER['HTTPS'])) $ht =' https';
            if(stristr($model->img,'upload/organisation/')){
                $previv = $ht.'://'.$_SERVER['SERVER_NAME'].'/'.$model->img;
            } else  $previv = $model->img;
        }
        if(!empty($model->logo)){
            $ht = 'http';
            if (isset($_SERVER['HTTPS'])) $ht =' https';
            if(stristr($model->logo,'upload/organisation/')){
                $logoPreviv = $ht.'://'.$_SERVER['SERVER_NAME'].'/'.$model->logo;
            } else  $logoPreviv = $model->logo;
        }
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description:ntext',
            'img',
            [
                'label' => 'Превью картинки',
                'value' =>  $previv,
                'format' => ['image',['width'=>'230','class'=>'postImg']],
            ],
            'logo',
             [
                'label' => 'Превью логотипа',
                'value' =>  $logoPreviv,
                'format' => ['image',['width'=>'230','class'=>'postImg']],
            ],
            'video',
            [
                'label' => 'Типы организации',
                'value' => implode('; ', ArrayHelper::map($model->types, 'id', 'name')),
            ],
            [
                'label' => 'Адреса организации',
                'value' => implode('; ', ArrayHelper::map($model->addresses, 'id', 'st_addr')),
            ],
                        [
                'label' => 'Профессии организации',
                'value' => implode('; ', ArrayHelper::map($model->professions, 'id', 'name')),
            ],
        ],
    ]) ?>

</div>
