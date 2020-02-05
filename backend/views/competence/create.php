<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Competence */

$this->title = 'Create Competence';
$this->params['breadcrumbs'][] = ['label' => 'Competences', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="competence-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
