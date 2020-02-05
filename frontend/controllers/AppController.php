<?php

/**

 * Created by PhpStorm.

 * User: gavor

 * Date: 20.02.2019

 * Time: 13:06

 */



namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\HttpException;

class AppController extends Controller

{

   /* public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                	[
                        'actions' => ['index','login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
					[
						'allow' => true,
						'ips' => [ '78.111.93.162','5.189.192.183','178.252.70.83','176.59.23.24'],
						'roles' => ['@'],
					],
					[
					    'allow' => false,
                        //'roles' => ['?'],
                        'denyCallback' => function ($rule, $action) {
		                    return $action->controller->redirect('index');
		                    //Yii::$app->response->statusCode = 403;
		                },
                    ],
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
    }*/

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                	'login',
                	'logout',
                	'signup',
                	'teachersig',
                	'resetpassword',
                	'tests',
                    'testview',
                	'profile',
                	'profileedit',
                	'mycompany',
                	'testedit',
                	'editmyevent',
                	//'event',
                	//'eventview'
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup','resetpassword','teachersig'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                        	'logout',
                        	'blog',
                            'blogview',
                        	'tests',
                        	'testview',
                        	'profile',
                        	'profileedit',
                        	'mycompany',
                        	'testedit',
                        	'editmyevent'
                        	//,'event',
                        	//'eventview'
                        ],
                        'roles' => ['@'],
                    ],
                    [
					    'allow' => false,
                        'denyCallback' => function ($rule, $action) {
		                 	throw new HttpException(403 ,'Доступ к данному разделу имеют только зарегестрированные пользователи'. PHP_EOL .' пожалуйста авторизуйтесь или зарегестрируйтесь!');
		                },
                    ],
                ],
            ]
        ];
    }

}