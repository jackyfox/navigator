<?php

namespace frontend\models;
use Yii;

class Profileedit extends \yii\db\ActiveRecord{

      public static function tableName()
      {
             return 'user'; // Имя таблицы в БД в которой хранятся записи блога
      }


      public static function getEdit()
      {		


      	$id = Yii::$app->user->identity->id;
      	$model = self::find()->where('id = :id', [':id' => $id])->one();


      	$username = $model['username'];
      	$first_name = $model['first_name'];
      	$last_name = $model['last_name'];

      	$request = Yii::$app->request;
      	#echo $request->post('email');
      	/*if(Yii::$app->request->post('email')) {
      		$email = Yii::$app->request->post('email');;
      		$model->email = $email;
			$model->save(); 
      	}*/
      	#$model->email = 'yii2@framework.com'; для обновления поля 
      	
      }


      public static function getCompAll() {

      	$query = "SELECT * FROM competence ORDER BY id";
      	$sql = Yii::$app->db->createCommand($query)->queryAll();

      	return $sql;
      }

      public static function getCompUser() {
      	
      	$id = Yii::$app->user->identity->id;
      	$query = "SELECT * FROM profile_has_competence 
      			  LEFT JOIN competence ON competence.id = profile_has_competence.competence_id 
      			  WHERE profile_id = $id";
      	$sql =  Yii::$app->db->createCommand($query)->queryAll();

      	return $sql;

      	
      }

      public static function getSchoolUser() {
            
            $id = Yii::$app->user->identity->id;

            #$query = "SELECT * FROM user 
            #              LEFT JOIN organisation ON  organisation.id = user.school
            #              WHERE user.id = $id";
            #$sql =  Yii::$app->db->createCommand($query)->queryAll();

           #if(count($sql) > 1) {
            #      return $sql;
            #}
            #else {
                  $query = "SELECT * FROM organisation_has_type 
                          LEFT JOIN organisation ON  organisation.id = organisation_has_type.organisation_id
                          WHERE type_id IN(1,2,5)";
                  $sql =  Yii::$app->db->createCommand($query)->queryAll(); 
                  return $sql;
            #}

            
      }

}