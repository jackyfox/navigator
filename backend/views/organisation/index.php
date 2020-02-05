<?php

use backend\models\Organisation;
//use backend\models\Type;
//use backend\models\Profession;
//use backend\models\Address;


use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrganisationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Организации';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organisation-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать Организации', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <!--<p style="color:#ff0000;">
        Если ошибка удаления где либо, то перед удалением, редактируем и снимаем галочки со связанных таблиц пока работает только так! если знаем где то меняем связь на каскадную и вуаля, баг исправлен 
    </p>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            //'description:ntext',
            //'img',
            //'logo',
            [
                'label' => 'Тип организации',
                'attribute' => 'type_id',
                //'filter' => Type::find()->select(['name', 'id'])->indexBy('id')->column(),
                'value' => function (Organisation $organisation) {
                        return implode(';', ArrayHelper::map($organisation->types, 'id', 'name'));
                    },
            ],
            /*[
                'label' => 'Адрес организации',
                'attribute' => 'address_id',
                'value' => function (Organisation $organisation) {
                        return implode('; ', ArrayHelper::map($organisation->addresses, 'id', 'st_addr'));
                    },
            ],*/
            /*[
                'label' => 'Профессии',
                'attribute' => 'profession_id',
                'value' => function (Organisation $organisation) {
                        return implode(';', ArrayHelper::map($organisation->professions, 'id', 'name'));
                    },
            ],*/

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
