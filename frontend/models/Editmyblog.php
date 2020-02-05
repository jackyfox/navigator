<?php

namespace frontend\models;
use Yii;

class Editmyblog extends \yii\db\ActiveRecord {

      public static function tableName()
      {
             return 'blog'; // Имя таблицы в БД в которой хранятся записи блога
      }

      public static function getBlog()
      {           
        if(isset($_GET['idBlog']) && isset($_GET['OrgID'])) {
        	  $org = (int)$_GET['OrgID'];
            $blog = (int)$_GET['idBlog'];
              //$data = self::find()->where('id = :id', [':id' => $id])->one();
              $query = "SELECT blog.title as titleBlog,blog.data as blogData , blog.id as blogID, blog.description as description, blog.img as imgBlog, organisation_has_blog.id_org as id_org FROM organisation_has_blog 
                        LEFT JOIN blog ON blog.id = organisation_has_blog.id_blog 
                        WHERE id_org =  $org AND id_blog = $blog
                        ORDER BY organisation_has_blog.id";

               $cmd = Yii::$app->db->createCommand($query)->queryOne();
               
              if(empty($cmd)) {
                  
              }
              else {
                    #print_r($data);
                    return $cmd;
              }
        }
        else {
              //echo "<h1 class='alert alert-danger' style='color: white;'>ОШИБКА 404!</h1>";
        }
      }

      public static function getComment() {
        if(isset($_GET['idBlog'])) {
              $id = (int)$_GET['idBlog'];

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