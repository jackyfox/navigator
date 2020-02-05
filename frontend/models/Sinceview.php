<?php

namespace frontend\models;
use Yii;

class Sinceview extends \yii\db\ActiveRecord {

      public static function tableName()
      {
             return 'organisation'; // Имя таблицы в БД в которой хранятся записи блога
      }


      public static function getFullSince()
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

      public static function getCompetenct() 
      {
	      	if(isset($_GET['id'])) {
	      		
	      		$id = (int)$_GET['id'];

	      		$competence = Yii::$app->db->createCommand("SELECT organisation_has_profession.organisation_id,organisation_has_profession.profession_id,profession_has_competence.competence_id,competence.name
				FROM organisation_has_profession
				LEFT JOIN profession_has_competence ON organisation_has_profession.profession_id = organisation_has_profession.profession_id
				LEFT JOIN competence ON id = profession_has_competence.competence_id
				WHERE organisation_has_profession.organisation_id = $id")->queryAll();

				if(empty($competence)) {

				}
				else {
					return $competence;
				}
			}
      }

      public static function getProf() 
      {
	      	if(isset($_GET['id'])) {
	      		
	      		$id = (int)$_GET['id'];


	      		$prof = Yii::$app->db->createCommand("SELECT organisation_has_profession.organisation_id,organisation_has_profession.profession_id,profession.name,profession.id,profession.img
				FROM organisation_has_profession
				LEFT JOIN profession ON id = organisation_has_profession.profession_id
				WHERE organisation_has_profession.organisation_id = $id")->queryAll();

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