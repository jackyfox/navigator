<?php

namespace frontend\models;
use Yii;

class Liststudents extends \yii\db\ActiveRecord{

      public static function tableName()
      {
             return 'organisation'; // Имя таблицы в БД в которой хранятся записи блога
      }


      public static function getStudents()
      {		

            if(isset($_GET['id'])) {
                  $user_id = Yii::$app->user->identity->id;
                  $id = (int)$_GET['id'];
                  $query = "SELECT organisation_has_personality.organisation_id, organisation_has_personality.personality_id, organisation_has_personality.type_personality, user.id ,user.username , user.first_name , user.last_name FROM organisation_has_personality 
                          LEFT JOIN user ON user.school = $id
                          WHERE personality_id = $user_id AND organisation_id = $id";
                  $cmd = Yii::$app->db->createCommand($query)->queryAll();
                  return $cmd;

            }
            else {
                  die('404!');
            }
      	
      }

      public static function getStudentsInProfile() 
      {
          $user_id = Yii::$app->user->identity->id;
          $query = "SELECT organisation_has_personality.organisation_id, organisation_has_personality.personality_id, organisation_has_personality.type_personality, user.id ,user.username , user.first_name , user.last_name FROM organisation_has_personality 
                          LEFT JOIN user ON user.school = organisation_has_personality.organisation_id
                          WHERE personality_id = $user_id AND type_personality IN(1,2)";
                  $cmd = Yii::$app->db->createCommand($query)->queryAll();
                  return $cmd;
      }


}