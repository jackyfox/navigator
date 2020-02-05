<?php

namespace frontend\models;
use Yii;

class Map extends \yii\db\ActiveRecord {

      public static function tableName()
      {
             return 'address'; // Имя таблицы в БД в которой хранятся записи блога
      }

      public static function getMap()
      {		
      		 //$data = self::find()->all();
             //return $data;
	      	$query = "SELECT org.id, org.name, ad.st_addr, ad.coords, t.name as name_type ,t.id as type_id
					FROM `organisation` as org 
			    RIGHT JOIN organisation_has_address as addr ON  org.id = addr.organisation_id
			    LEFT JOIN address as ad ON addr.address_id = ad.id
			    LEFT JOIN organisation_has_type as ortt ON org.id = ortt.organisation_id
			    LEFT JOIN type as t ON ortt.type_id = t.id
			    LEFT JOIN organisation_has_profession as pr ON org.id = pr.organisation_id
			    LEFT JOIN profession as prof ON pr.profession_id = prof.id
			    LEFT JOIN profession_has_competence as c ON c.profession_id = prof.id
			    LEFT JOIN competence as com ON c.competence_id = com.id
			   
			    	GROUP BY addr.address_id, addr.organisation_id
";
/*

			LEFT JOIN organisation_has_type ON organisation_has_type.organisation_id = organisation_has_address.organisation_id
			LEFT JOIN type ON type.id = organisation_has_type.type_id
			LEFT JOIN organisation_has_profession ON organisation_has_profession.organisation_id = organisation_has_address.organisation_id
			LEFT JOIN profession_has_competence ON profession_has_competence.profession_id = organisation_has_profession.profession_id
			LEFT JOIN competence ON competence.id = profession_has_competence.profession_id
			*/

			$data = Yii::$app->db->createCommand($query)->queryAll();
	      		 return $data;
      }

      public static function getPofNameForFilter() {

        $prof = Yii::$app->db->createCommand("SELECT name,id,description
            		FROM profession")->queryAll();

        if(empty($prof)) {
            
        }
        else {
        	return $prof;
        }

      }

      public static function getOrganisationTypeForFilter() {

        $typeOrg = Yii::$app->db->createCommand("SELECT name,id
            		FROM type")->queryAll();

        if(empty($typeOrg)) {
            
        }
        else {
        	return $typeOrg;
        }

      }

      public static function getCompetenceNameForFilter() {

        $competence = Yii::$app->db->createCommand("SELECT name,id,description
            		FROM competence")->queryAll();

        if(empty($competence)) {
            
        }
        else {
        	return $competence;
        }

      }

}