<?php
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Profession */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Профессии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="profession-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' =>'Вы уверины что хотите удалить профессию?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php
    if(!empty($model->img)){
        $ht = 'http';
        if (isset($_SERVER['HTTPS'])) $ht =' https';
        if(stristr($model->img,'upload/profession/')){
            $previv = $ht.'://'.$_SERVER['SERVER_NAME'].'/'.$model->img;
        } else  $previv = $model->img;
    }
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'short_desc',
            'description:ntext',
            [
                'label' => 'Компитенции',
                'value' => implode('; ', ArrayHelper::map($model->competences, 'id', 'name')),
            ],
            'img',
            [
                'label' => 'Превью картинки',
                'value' =>  $previv,
                'format' => ['image',['width'=>'230','class'=>'postImg']],
            ],
            'video',
            'low_salary',
            'high_salary',
            'created_at',
            'deleted_at',
            'updated_at',
        ],
    ]) ?>

</div>
