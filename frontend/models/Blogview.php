<?php

namespace frontend\models;
use Yii;

class Blogview extends \yii\db\ActiveRecord {

      public static function tableName()
      {
             return 'blog'; // Имя таблицы в БД в которой хранятся записи блога
      }

      public static function getBlog()
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

      public static function getComment() {
        if(isset($_GET['id'])) {
              $id = (int)$_GET['id'];

              $sql = "SELECT comments.id as commentsID, comments.id_blog as idBlogComments, comments.comments as commentsText, comments.time as commentsTime, user.username as username, user.first_name as first_name, user.last_name as last_name, user.avatar as avatar, profile.is_blocked as is_blocked FROM comments 
                LEFT JOIN user ON user.id =  comments.id_user
                LEFT JOIN profile ON profile.id_users =  comments.id_user
              WHERE comments.id_blog = '$id' ORDER BY comments.id";
              $cmd = Yii::$app->db->createCommand($sql)->queryAll();

              return $cmd;
        }
        else {

        }
      }

}