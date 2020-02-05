<?php

namespace frontend\models;
use Yii;

class Testview extends \yii\db\ActiveRecord {

      public static function tableName()
      {
             return 'test'; // Имя таблицы в БД в которой хранятся записи блога
      }

      public static function getFullTest()
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


      public static function getOrg() {
      	if(isset($_GET['id'])) {
      		$id = (int)$_GET['id'];
      		$query = "SELECT * FROM organisation_has_test LEFT JOIN organisation ON organisation.id = organisation_has_test.id_org WHERE id_test = $id";
      		$cmd = Yii::$app->db->createCommand($query)->queryAll();
      		return $cmd;
      	}
      }

      public static function getSlider() {
      	if(isset($_GET['id'])) {
      		$id = (int)$_GET['id'];
      		$query = "SELECT * FROM slider_test WHERE id_test = $id";
      		$cmd = Yii::$app->db->createCommand($query)->queryAll();
      		return $cmd;
      	}
      }

      public static function getUserComplite() {
        if(isset($_GET['id'])) {
          $idTest = (int)$_GET['id'];
          $user_id = Yii::$app->user->identity->id;
          $query = "SELECT * FROM TestCompliteUser WHERE id_test = '$idTest' AND idUser = '$user_id'";
          $cmd = Yii::$app->db->createCommand($query)->queryOne();
          return $cmd;
        }
      
      }


}