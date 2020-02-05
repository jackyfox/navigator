<?php

namespace frontend\models;
use Yii;

class Viewprof extends \yii\db\ActiveRecord {

      public static function tableName()
      {
             return 'profession'; // Имя таблицы в БД в которой хранятся записи блога
      }


      public static function getProfDetail()
      {		
      		if(isset($_GET['id'])) {
      			$id = (int)$_GET['id'];
      			$data = self::find()->where('id = :id', [':id' => $id])->one();
      			if(empty($data)) {
      				#echo "<h1 class='alert alert-danger' style='color: white;'>Хитрый хацкер -__- !</h1>";
      			}
      			else {
      				#print_r($data);
      				return $data;
      			}
      		}
      		else {
      			#echo "<h1 class='alert alert-danger' style='color: white;'>ОШИБКА 404!</h1>";
      		}
      }

      public static function getFavoriteUser() {
      		if (isset($_GET['id'])) { $id = (int)$_GET['id']; } else { die('error'); }
      			if (Yii::$app->user->isGuest) {

      			}
      			else {
		     		$id_user = Yii::$app->user->id;

		     		$query = "SELECT * FROM profile_favorite_profession WHERE id_profile = $id_user AND id_profession = $id";
		     		$cmd = Yii::$app->db->createCommand($query)->queryOne();

		     		return $cmd;
	     		}
      }

      public static function getSlide() 
      {
	      	if(isset($_GET['id'])) {
		      		
		      	$id = (int)$_GET['id'];

		      	$slider = Yii::$app->db->createCommand("SELECT * FROM slider_prof WHERE id_prof = $id")->queryAll();

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

	      		$competence = Yii::$app->db->createCommand("SELECT competence_id,profession_id,
    			(SELECT name FROM competence WHERE id = competence_id) AS competence_name
    			FROM profession_has_competence WHERE profession_id = $id")->queryAll();

				if(empty($competence)) {

				}
				else {
					return $competence;
				}
			}
      }

      public static function getOrganistation() 
      {
	      	if(isset($_GET['id'])) {

	      		$id = (int)$_GET['id'];
	      	 	
				/*$profession = Yii::$app->db->createCommand("SELECT organisation_has_profession.organisation_id,organisation_has_profession.profession_id,organisation.name,organisation.id,organisation.img,organisation_has_type.type_id
				FROM organisation_has_profession
				LEFT JOIN organisation ON id = organisation_has_profession.organisation_id
				LEFT JOIN organisation_has_type ON organisation_has_type.organisation_id = organisation.id
				WHERE organisation_has_profession.profession_id = $id")->queryAll();*/
                        $profession = Yii::$app->db->createCommand("SELECT organisation_has_profession.organisation_id,organisation_has_profession.profession_id,organisation.name,organisation.id,organisation.img,organisation_has_type.type_id
                        FROM organisation_has_profession
                        LEFT JOIN organisation ON id = organisation_has_profession.organisation_id
                        LEFT JOIN organisation_has_type ON organisation_has_type.organisation_id = organisation.id
                        WHERE organisation_has_profession.profession_id = $id GROUP BY organisation_has_type.organisation_id")->queryAll();


				if(empty($profession)) {

				}
				else {
					return $profession;
				}
			}
      }

      public static function getAddres() {
      	if(isset($_GET['id'])) {
      		$id = (int)$_GET['id'];
      		$query = "SELECT address.st_addr as st_addr,address.coords as coords, organisation.name as name ,organisation.id as id ,type.name as type_name, type.id as type_id FROM organisation_has_address 
      			LEFT JOIN organisation ON id = organisation_has_address.organisation_id
      			LEFT JOIN address ON address.id = organisation_has_address.address_id
      			LEFT JOIN organisation_has_type ON organisation_has_type.organisation_id = organisation.id
      			LEFT JOIN type ON type.id = organisation_has_type.type_id 
      			LEFT JOIN organisation_has_profession ON organisation_has_profession.profession_id = $id WHERE organisation_has_address.organisation_id = organisation_has_profession.organisation_id";

      		$cmd = Yii::$app->db->createCommand($query)->queryAll();

      		return $cmd;
      		
      	}
      }
}