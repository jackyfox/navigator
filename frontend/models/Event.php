<?php

namespace frontend\models;
use yii\data\Pagination;
use Yii;

class Event extends \yii\db\ActiveRecord {

      public static function tableName()
      {
             return 'event'; // Имя таблицы в БД в которой хранятся записи блога
      }


      public static function getEvent()
      {		
      		//$cmd = Yii::$app->db->createCommand("SELECT id,name,img,description, 
      		//	(SELECT type_id FROM organisation_has_type WHERE organisation_id = id AND type_id = 4 AND type_id = 2) AS type_id
      		//	FROM organisation ORDER BY id")->queryAll();

      		$cmd = Yii::$app->db->createCommand("SELECT * FROM event ORDER BY event_time DESC")->queryAll();

      		return $cmd;
      }

      public static function getSlider() {

            $query = "SELECT * FROM slider_event  LEFT JOIN event ON event.id = slider_event.id_event ORDER BY slider_event.id";

            $cmd = Yii::$app->db->createCommand($query)->queryAll();

            return $cmd; 
      }
}