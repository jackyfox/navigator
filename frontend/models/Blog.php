<?php

namespace frontend\models;
use Yii;

class Blog extends \yii\db\ActiveRecord {

      public static function tableName()
      {
             return 'blog'; // Имя таблицы в БД в которой хранятся записи блога
      }


      public static function getBlog()
      {		
      		//$cmd = Yii::$app->db->createCommand("SELECT id,name,img,description, 
      		//	(SELECT type_id FROM organisation_has_type WHERE organisation_id = id AND type_id = 4 AND type_id = 2) AS type_id
      		//	FROM organisation ORDER BY id")->queryAll();

      		$cmd = Yii::$app->db->createCommand("SELECT * FROM blog ORDER BY id")->queryAll();

                  $cmd = Yii::$app->db->createCommand("SELECT blog.title as titleBlog,blog.data as blogData , blog.id as blogID, blog.description as description, blog.img as imgBlog, organisation_has_blog.id_org as id_org, organisation.name as orgName, organisation.logo as logoOrg FROM blog 
                        LEFT JOIN organisation_has_blog ON organisation_has_blog.id_blog = blog.id
                        LEFT JOIN organisation ON organisation.id = organisation_has_blog.id_org
                        ORDER BY blog.id")->queryAll();
      		return $cmd;
      }


}