<?php

namespace frontend\models;
use Yii;


class Prof extends \yii\db\ActiveRecord {

      public static function tableName()
      {
             return 'profession'; // Имя таблицы в БД в которой хранятся записи блога
      }


      public static function getProf()
      {		
       		if(Yii::$app->request->isAjax){
    			
    			$json = Yii::$app->request->post();

    			echo json_encode($json);
            }            
            $data = self::find()->all();
            return $data;
             
      }

      public static function getFavoriteProf() 
      {
	      	if (Yii::$app->user->isGuest) {

	        }
	        else {
	        	$id = Yii::$app->user->identity->id;


            	$favorite = Yii::$app->db->createCommand("SELECT id_profession,
            		(SELECT name FROM profession WHERE id = id_profession) AS name_prof,
            		(SELECT img FROM profession WHERE id = id_profession) AS img_prof,
            		(SELECT id FROM profession WHERE id = id_profession) AS id_prof
            		FROM profile_favorite_profession WHERE id_profile = $id")->queryAll();

            	if(empty($favorite)) {
            
            	}
            	else {
            		return $favorite;
            	}
	        }
      }
}