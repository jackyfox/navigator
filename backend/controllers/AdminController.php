<?php

/**

 * Created by PhpStorm.

 * User: gavor

 * Date: 20.02.2019

 * Time: 13:06

 */



namespace backend\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class AdminController extends Controller

{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                	[
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
					[
						'allow' => true,
						'ips' => [ '78.111.93.162' /*академия*/,'5.189.192.183','178.252.70.83'],
					],
					[
					    'allow' => false,
                        //'roles' => ['?'],
                        'denyCallback' => function ($rule, $action) {
		                    return $action->controller->redirect('index');
		                    //throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.')); 
		                },
                    ],

                    //'only' => ['logout', 'signup','login'],
                    /*[
                        'actions' => ['signup','login'],
                        'allow' => true,
                        'roles' => ['?'],
                       	'ips' => ['127.0.0.1'],
                    ],*/
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

}