<?php

namespace frontend\models;
use Yii;

class Tests extends \yii\db\ActiveRecord {

      public static function tableName()
      {
             return 'test'; // Имя таблицы в БД в которой хранятся записи блога
      }


      public static function getTests()
      {		
      		
      	$query = "SELECT * FROM test ORDER BY id";
         $sql = Yii::$app->db->createCommand($query)->queryAll();

         return $sql;
      }


      public static function getSlider() {
         $query = "SELECT test.id as id, test.title as title, slider_test.img as img, test.data_start as data_start, test.data_end as data_end FROM slider_test 
                  LEFT JOIN test ON test.id = slider_test.id_test WHERE test_main_page = 1";
         $sql = Yii::$app->db->createCommand($query)->queryAll();

         return $sql;
      }
}