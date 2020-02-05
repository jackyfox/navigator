<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Profession */

$this->title = 'Создать Профессию';
$this->params['breadcrumbs'][] = ['label' => 'Профессии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profession-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
