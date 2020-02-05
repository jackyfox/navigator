<?php

namespace frontend\models;
use Yii;

class Eventview extends \yii\db\ActiveRecord {

      public static function tableName()
      {
             return 'event'; // Имя таблицы в БД в которой хранятся записи блога
      }

      public static function getFullEvent()
      {           
        if(isset($_GET['id'])) {
              $id = (int)$_GET['id'];
              $data = self::find()->where('id = :id', [':id' => $id])->one();
              if(empty($data)) {
                  
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

		     		$query = "SELECT * FROM profile_favorite_event WHERE id_user = $id_user AND id_event = $id";
		     		$cmd = Yii::$app->db->createCommand($query)->queryOne();

		     		return $cmd;
	     		}
      }

      public static function getOrg() {
      	if(isset($_GET['id'])) {
      		$id = (int)$_GET['id'];
      		$query = "SELECT * FROM event_has_organisation LEFT JOIN organisation ON organisation.id = event_has_organisation.id_org WHERE id_event = $id";
      		$cmd = Yii::$app->db->createCommand($query)->queryAll();
      		return $cmd;
      	}
      }

      public static function getAdres() {
       	if(isset($_GET['id'])) {
      		$id = (int)$_GET['id'];
      		$query = "SELECT * FROM event_has_address LEFT JOIN address ON address.id = event_has_address.address_id WHERE event_id = $id";
      		$cmd = Yii::$app->db->createCommand($query)->queryAll();
      		return $cmd;
      	}           
      }

      public static function getSlider() {
      	if(isset($_GET['id'])) {
      		$id = (int)$_GET['id'];
      		$query = "SELECT * FROM slider_event WHERE id_event = $id";
      		$cmd = Yii::$app->db->createCommand($query)->queryAll();
      		return $cmd;
      	}
      }

      public static function getNoti() {
        if (Yii::$app->user->isGuest) {

            }
        else {
      	if(isset($_GET['id'])) {
      		$id_event = $_GET['id'];
      		$id_user = Yii::$app->user->id;

      		$query = "SELECT * FROM profile_has_notification WHERE id_user = $id_user AND id_event = $id_event";
      		$cmd = Yii::$app->db->createCommand($query)->queryAll();
      		return $cmd;
      	}
      }
    }
}