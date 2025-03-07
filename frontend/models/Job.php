<?php

namespace frontend\models;
use Yii;

class Job extends \yii\db\ActiveRecord {

      public static function tableName()
      {
             return 'organisation'; // Имя таблицы в БД в которой хранятся записи блога
      }


      public static function getJob()
      {		
      		//$cmd = Yii::$app->db->createCommand("SELECT id,name,img,description, 
      		//	(SELECT type_id FROM organisation_has_type WHERE organisation_id = id AND type_id = 4 AND type_id = 2) AS type_id
      		//	FROM organisation ORDER BY id")->queryAll();

      		$cmd = Yii::$app->db->createCommand("SELECT id,name,img,description,type_id
      			FROM organisation RIGHT JOIN organisation_has_type ON organisation_id = id WHERE type_id = 4 OR type_id = 2")->queryAll();


      		return $cmd;
      }


      public static function getJobFavorite() 
      {
	      	if (Yii::$app->user->isGuest) {

	        }
	        else {
	        	$id = Yii::$app->user->identity->id;


            	/*$favorite = Yii::$app->db->createCommand("SELECT organisation_id,
            		(SELECT name FROM organisation WHERE id = organisation_id) AS name_org,
            		(SELECT img FROM organisation WHERE id = organisation_id) AS img_org,
            		(SELECT id FROM organisation WHERE id = organisation_id) AS id_org,
            		(SELECT type_id FROM organisation_has_type WHERE organisation_id = id_org) AS type_id
            		FROM profile_favorite_organisation WHERE profile_id = $id")->queryAll();*/

            	$favorite = Yii::$app->db->createCommand("SELECT * FROM profile_favorite_organisation 
					LEFT JOIN organisation 
					ON organisation.id =  profile_favorite_organisation.organisation_id 
					LEFT JOIN organisation_has_type 
					ON organisation_has_type.organisation_id = profile_favorite_organisation.organisation_id 
					WHERE profile_id = $id")->queryAll();

            	if(empty($favorite)) {
            
            	}
            	else {
            		return $favorite;
            	}
	        }
      }
}