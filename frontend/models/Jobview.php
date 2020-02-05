<?php

namespace frontend\models;
use Yii;

class Jobview extends \yii\db\ActiveRecord {

      public static function tableName()
      {
             return 'organisation'; // Имя таблицы в БД в которой хранятся записи блога
      }


      public static function getFullJob()
      {		

      		if(isset($_GET['id'])) {
      			$id = (int)$_GET['id'];
      			$data = self::find()->where('id = :id', [':id' => $id])->one();
      			if(empty($data)) {

      			}
      			else {
      				return $data;
      			}
      		}
 
      }

      public static function typeOrg() {
            if(isset($_GET['id'])) {
              $id = (int)$_GET['id'];
            }
            $query = "SELECT * FROM organisation_has_type WHERE organisation_id = $id";
            $cmd = Yii::$app->db->createCommand($query)->queryOne();

            return $cmd;
      }

     public static function getFavoriteUser() {
      		if (isset($_GET['id'])) { $id = (int)$_GET['id']; } else { die('error'); }
      			if (Yii::$app->user->isGuest) {

      			}
      			else {
		     		$id_user = Yii::$app->user->id;

		     		$query = "SELECT * FROM profile_favorite_organisation WHERE profile_id = $id_user AND organisation_id = $id";
		     		$cmd = Yii::$app->db->createCommand($query)->queryOne();

		     		return $cmd;
	     		}
      }
      
      public static function getSlide() 
      {
	      	if(isset($_GET['id'])) {
		      		
		      	$id = (int)$_GET['id'];

		      	$slider = Yii::$app->db->createCommand("SELECT * FROM slider_org WHERE id_org = $id")->queryAll();

				if(empty($slider)) {

				}
				else {
					return $slider;
				}
			
		    }
      }

      public static function getProf() 
      {
	      	if(isset($_GET['id'])) {
	      		
	      		$id = (int)$_GET['id'];

	      		$prof = Yii::$app->db->createCommand("SELECT organisation_id,profession_id,
    			(SELECT name FROM profession WHERE id = profession_id) AS name_prof,
    			(SELECT img FROM profession WHERE id = profession_id) AS img_prof,
    			(SELECT id FROM profession WHERE id = profession_id) AS id_prof
    			FROM organisation_has_profession WHERE organisation_id = $id")->queryAll();

				if(empty($prof)) {

				}
				else {
					return $prof;
				}
			}
      }

      public static function getAdres() {
      	if(isset($_GET['id'])) {
      		$id = (int)$_GET['id'];

      		$query = "SELECT * FROM organisation_has_address 
      		LEFT JOIN address ON address.id = organisation_has_address.address_id
      		LEFT JOIN organisation ON organisation.id = organisation_has_address.organisation_id
          LEFT JOIN organisation_has_type ON organisation_has_type.organisation_id = organisation_has_address.organisation_id
          LEFT JOIN type ON type.id = organisation_has_type.type_id
      		WHERE organisation_has_address.organisation_id = $id";

      		$cmd = Yii::$app->db->createCommand($query)->queryAll();

      		if(empty($cmd)) {

      		}
      		else {
      			return $cmd;
      		}
      	}
      }

}