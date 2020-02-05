<?php

namespace frontend\models;
use Yii;

class ProfilePage extends \yii\db\ActiveRecord{

      public static function tableName()
      {
             return 'user'; // Имя таблицы в БД в которой хранятся записи блога
      }


      public static function getAll()
      {		
      		if(isset($_GET['id'])) {
      			$id = (int)$_GET['id'];
      			$data = self::find()->where('id = :id', [':id' => $id])->one();
      			if(empty($data)) {
      				
      			}
      			else {


      				$group = Yii::$app->db->createCommand("SELECT group_id FROM user_has_group WHERE user_id = $id")->queryOne();
      				
      				if(empty($group)) {

      					$id = (int)$_GET['id'];

       					$group_user_add = Yii::$app->db->createCommand()->insert('user_has_group', [
																					    'user_id' => $id,
																					    'group_id' => 2,
																					])->execute();
       					
       					$group = Yii::$app->db->createCommand("SELECT group_id FROM user_has_group WHERE user_id = $id")->queryOne();

       					$gorup_id = $group['group_id'];

	            		$group_name = Yii::$app->db->createCommand("SELECT name FROM `group` WHERE id = $gorup_id")->queryOne();

	      				return array($data,$group_name);
      				}
      				else {
						
						$gorup_id = $group['group_id'];

	            		$group_name = Yii::$app->db->createCommand("SELECT name FROM `group` WHERE id = $gorup_id")->queryOne();

	      				return array($data,$group_name);
      				}

            	
      			}
      		}
            else {
            	if (Yii::$app->user->isGuest) {

            	}
            	else {
            		$id = Yii::$app->user->identity->id;

            		$group = Yii::$app->db->createCommand("SELECT group_id FROM user_has_group WHERE user_id = $id")->queryOne();
            		
            		if(empty($group)) {
            			$id = Yii::$app->user->getId();

            			$group_user_add = Yii::$app->db->createCommand()->insert('user_has_group', [
																					    'user_id' => $id,
																					    'group_id' => 2,
																					])->execute();

            			$group = Yii::$app->db->createCommand("SELECT group_id FROM user_has_group WHERE user_id = $id")->queryOne();

            			$gorup_id = $group['group_id'];

	            		$group_name = Yii::$app->db->createCommand("SELECT name FROM `group` WHERE id = $gorup_id")->queryOne();
	            		
	            		return $group_name;
            		}
            		else {

	            		$gorup_id = $group['group_id'];

	            		$group_name = Yii::$app->db->createCommand("SELECT name FROM `group` WHERE id = $gorup_id")->queryOne();
	            		
	            		return $group_name;
	            	}
            	}
            	
            
            	#echo "PAGE NOT FOUND!";
            }
      }

      public static function getProfileInfo() {
	      	
	      	if(isset($_GET['id'])) {
	      		$id = (int)$_GET['id'];

	      		$ProfileSql = Yii::$app->db->createCommand("SELECT * FROM profile WHERE id_users = $id")->queryOne();
	      		$data = self::find()->where('id = :id', [':id' => $id])->one();
	      		if(empty($data)) {
	      			#echo "пользователь не найден";
	      		}
	      		else {
		      		if(empty($ProfileSql)) {

	      					$date = date("Y-m-d H:i:s");
	      					$group_user_add = Yii::$app->db->createCommand()->insert('profile', [
																						    'id_users' => $id,
																						    'expirience' => 0,
																						    'level' => 1,
																						    'is_active' => 10,
																						    'is_reported' => 0,
																						    'is_blocked' => 0,
																						    'created_at' => $date,
																						    'deleted_at' => $date,
																						    'updated_at' => $date,
																						])->execute();
	      					$profil_get_info = Yii::$app->db->createCommand("SELECT * FROM profile WHERE id = $id")->queryOne();
	      				
	      					$ProfileSql = Yii::$app->db->createCommand("SELECT * FROM profile WHERE id = $id")->queryOne();	

	      					return $ProfileSql;
		      		}
		      		else {
		      			return $ProfileSql;
		      		}
	      		}


	      	}
	      	else {
	      		if (Yii::$app->user->isGuest) {

            	}
            	else {
            		$id = Yii::$app->user->identity->id;
            		$ProfileSql = Yii::$app->db->createCommand("SELECT * FROM profile WHERE id_users = $id")->queryOne();

            		if(empty($ProfileSql)) {
            			$date = date("Y-m-d H:i:s");
      					$group_user_add = Yii::$app->db->createCommand()->insert('profile', [
																					    'id_users' => $id,
																					    'expirience' => 0,
																					    'level' => 1,
																					    'is_active' => 10,
																					    'is_reported' => 0,
																					    'is_blocked' => 0,
																					    'created_at' => $date,
																					    'deleted_at' => $date,
																					    'updated_at' => $date,
																					])->execute();
      					$profil_get_info = Yii::$app->db->createCommand("SELECT * FROM profile WHERE id = $id")->queryOne();
      				
      					$ProfileSql = Yii::$app->db->createCommand("SELECT * FROM profile WHERE id = $id")->queryOne();	
      					
      					return $ProfileSql;
            		}
            		else {
            			return $ProfileSql;
            		}
            	}
	      	}

      }

      public static function getOrgUser() {
      	if(isset($_GET['id'])) {
	      		$id = (int)$_GET['id'];

	      		
	      		$ProfileOrg = Yii::$app->db->createCommand("SELECT organisation.id,profile_favorite_organisation.organisation_id,organisation.name,organisation.img,type_id 
					FROM profile_favorite_organisation 
					LEFT JOIN organisation 
					ON organisation.id =  profile_favorite_organisation.organisation_id 
					LEFT JOIN organisation_has_type 
					ON organisation_has_type.organisation_id = profile_favorite_organisation.organisation_id 
					WHERE profile_id = $id")->queryAll();

	      		if(empty($ProfileOrg)) {

	      		}
	      		else {

	      			return $ProfileOrg;
	      		}


	      	}
	      	else {
	      		if (Yii::$app->user->isGuest) {

            	}
            	else {
            		$id = Yii::$app->user->identity->id;
	      			$ProfileOrg = Yii::$app->db->createCommand("SELECT organisation.id,profile_favorite_organisation.organisation_id,organisation.name,organisation.img,type_id 
					FROM profile_favorite_organisation 
					LEFT JOIN organisation 
					ON organisation.id =  profile_favorite_organisation.organisation_id 
					LEFT JOIN organisation_has_type 
					ON organisation_has_type.organisation_id = profile_favorite_organisation.organisation_id 
					WHERE profile_id = $id")->queryAll();
	      		
		      		if(empty($ProfileOrg)) {

		      		}
		      		else {

		      			return $ProfileOrg;
		      		}
            	}
	      	}
      }


    public static function getProfessionUser() {
      	if(isset($_GET['id'])) {
	      		$id = (int)$_GET['id'];

	      		$ProfileProf = Yii::$app->db->createCommand("SELECT profile_favorite_profession.id,profile_favorite_profession.id_profession,profession.name,profession.img FROM profile_favorite_profession LEFT JOIN profession ON profession.id =profile_favorite_profession.id_profession WHERE profile_favorite_profession.id_profile = $id")->queryAll();
	      		
	      		if(empty($ProfileProf)) {

	      		}
	      		else {

	      			return $ProfileProf;
	      		}


	      	}
	      	else {
	      		if (Yii::$app->user->isGuest) {

            	}
            	else {
            		$id = Yii::$app->user->identity->id;
	      			$ProfileProf = Yii::$app->db->createCommand("SELECT profile_favorite_profession.id,profile_favorite_profession.id_profession,profession.name,profession.img FROM profile_favorite_profession LEFT JOIN profession ON profession.id =profile_favorite_profession.id_profession WHERE profile_favorite_profession.id_profile = $id")->queryAll();
	      		
		      		if(empty($ProfileProf)) {

		      		}
		      		else {

		      			return $ProfileProf;
		      		}
            	}
	      	}
      }


      public static function getAchiv() {
      		if(isset($_GET['id'])) {
      			$id = (int)$_GET['id'];
      			$data = self::find()->where('id = :id', [':id' => $id])->one();
	      		
	      		if(empty($data)) {
	      				#echo "пользователь не найден";
	      		}
      			else {
	      			$sql = "SELECT * FROM profile_has_achievement 
					LEFT JOIN achievement ON achievement.id = profile_has_achievement.achievement_id
		      		WHERE profile_id = $id ORDER BY profile_has_achievement.id DESC LIMIT 1";

		      		$cmd = Yii::$app->db->createCommand($sql)->queryOne();

		      		if(empty($cmd)) {
		      			$date = date("m.d.y");
		      			$group_user_add = Yii::$app->db->createCommand()->insert('profile_has_achievement', [
										    'profile_id' => $id,
										    'achievement_id' => 1,
										    'created_at' => $date,
										    'deleted_at' => $date,
										    'updated_at' => $date,
										])->execute();

		      			$cmd = Yii::$app->db->createCommand($sql)->queryOne();

		      			return $cmd;
		      		}
		      		else {
		      			return $cmd;
		      		}
		      	}
      		}
      		else {
      			$id = Yii::$app->user->identity->id;

      			$data = self::find()->where('id = :id', [':id' => $id])->one();
	      		if(empty($data)) {
	      			#echo "пользователь не найден";
	      		}

	      		else {
	      			$sql = "SELECT * FROM profile_has_achievement 
					LEFT JOIN achievement ON achievement.id = profile_has_achievement.achievement_id
		      		WHERE profile_id = $id ORDER BY profile_has_achievement.id DESC LIMIT 1";

		      		$cmd = Yii::$app->db->createCommand($sql)->queryOne();

		      		if(empty($cmd)) {
		      			$date = date("m.d.y");
		      			$group_user_add = Yii::$app->db->createCommand()->insert('profile_has_achievement', [
										    'profile_id' => $id,
										    'achievement_id' => 1,
										    'created_at' => $date,
										    'deleted_at' => $date,
										    'updated_at' => $date,
										])->execute();

		      			$cmd = Yii::$app->db->createCommand($sql)->queryOne();

		      			return $cmd;
		      		}
		      		else {
		      			return $cmd;
		      		}
		      	}
      		}
      		
      }

      public static function getAllAchivUser() {
      	if(isset($_GET['id'])) {
      		$id = (int)$_GET['id'];

      		$sql = "SELECT * FROM profile_has_achievement 
				LEFT JOIN achievement ON achievement.id = profile_has_achievement.achievement_id
	      		WHERE profile_id = $id ORDER BY profile_has_achievement.id";

	      	$cmd = Yii::$app->db->createCommand($sql)->queryAll();

	      	return $cmd;
      	}
      	else {
      		$id = Yii::$app->user->identity->id;
      		$sql = "SELECT * FROM profile_has_achievement 
				LEFT JOIN achievement ON achievement.id = profile_has_achievement.achievement_id
	      		WHERE profile_id = $id ORDER BY profile_has_achievement.id";

	      	$cmd = Yii::$app->db->createCommand($sql)->queryAll();

	      	return $cmd;
      	}

      }

      public static function getCompetenc() {
      	if(isset($_GET['id'])) {
      		$id = (int)$_GET['id'];
      		$sql = "SELECT * FROM profile_has_competence LEFT JOIN competence ON competence.id = profile_has_competence.competence_id
      		WHERE profile_has_competence.profile_id = $id";

      		$cmd = Yii::$app->db->createCommand($sql)->queryAll();

      		return $cmd;
      	}
      	else {
      		$id = Yii::$app->user->identity->id;
      		$sql = "SELECT * FROM profile_has_competence LEFT JOIN competence ON competence.id = profile_has_competence.competence_id
      		WHERE profile_has_competence.profile_id = $id";

      		$cmd = Yii::$app->db->createCommand($sql)->queryAll();

      		return $cmd;
      	}
      }


      public static function getEventUser() {
      	if(isset($_GET['id'])) {
      		$id = (int)$_GET['id'];
      		$sql = "SELECT * FROM profile_favorite_event LEFT JOIN event ON event.id = profile_favorite_event.id_event
      		WHERE id_user = $id";

      		$cmd = Yii::$app->db->createCommand($sql)->queryAll();

      		return $cmd;
      	}
      	else {
      		$id = Yii::$app->user->identity->id;
      		$sql = "SELECT * FROM profile_favorite_event LEFT JOIN event ON event.id = profile_favorite_event.id_event
      		WHERE id_user = $id";

      		$cmd = Yii::$app->db->createCommand($sql)->queryAll();

      		return $cmd;
      	}
      }
      
      public static function getUserCompany() {
      	if(isset($_GET['id'])) {
      		$id = (int)$_GET['id'];
      		$sql = "SELECT * FROM organisation_has_personality 
      				LEFT JOIN organisation ON organisation.id = organisation_has_personality.organisation_id
      				LEFT JOIN organisation_has_type ON organisation_has_type.organisation_id = organisation_has_personality.organisation_id
      				WHERE organisation_has_personality.personality_id = $id";
      		$cmd = Yii::$app->db->createCommand($sql)->queryAll();
      		return $cmd;
      	}
      	else {
      		$id = Yii::$app->user->identity->id;
      		$sql = "SELECT * FROM organisation_has_personality 
      				LEFT JOIN organisation ON organisation.id = organisation_has_personality.organisation_id
      				LEFT JOIN organisation_has_type ON organisation_has_type.organisation_id = organisation_has_personality.organisation_id
      				WHERE organisation_has_personality.personality_id = $id";
      		$cmd = Yii::$app->db->createCommand($sql)->queryAll();
      		return $cmd;
      	}
      }

      public static function getNoti() {
    		$id = Yii::$app->user->identity->id;

    		$query = "SELECT * FROM profile_has_notification 
					  LEFT JOIN event ON event.id = profile_has_notification.id_event
    		WHERE id_user = $id ORDER BY is_reed DESC";

    		$cmd = Yii::$app->db->createCommand($query)->queryAll();
      		return $cmd;
      }

      public static function getSert() {
    		if(isset($_GET['id'])) {
      			$id = (int)$_GET['id'];

      			$query = "SELECT user_link_certificate.id_user,user_link_certificate.id_test,user_link_certificate.link_certificate,test.id,test.title FROM user_link_certificate
					LEFT JOIN test ON test.id = user_link_certificate.id_test
    				WHERE id_user =	$id ORDER BY id DESC";

    			$cmd = Yii::$app->db->createCommand($query)->queryAll();
      			return $cmd;
      		}
      		else {

    		$id = Yii::$app->user->identity->id;

    		$query = "SELECT user_link_certificate.id_user,user_link_certificate.id_test,user_link_certificate.link_certificate,test.id,test.title FROM user_link_certificate
					  LEFT JOIN test ON test.id = user_link_certificate.id_test
    		WHERE id_user =	$id ORDER BY id DESC";

    		$cmd = Yii::$app->db->createCommand($query)->queryAll();
      		return $cmd;

      		}
      }
      public static function getUserSertCustom() {
      		if(isset($_GET['id'])) {
      			$id = (int)$_GET['id'];
      			$query = "SELECT * FROM profile_has_portfolio WHERE id_user = $id ORDER BY id DESC";

    			$cmd = Yii::$app->db->createCommand($query)->queryAll();
      			return $cmd;
      		}
      		else {

    		$id = Yii::$app->user->identity->id;

    		$query = "SELECT * FROM profile_has_portfolio WHERE id_user = $id ORDER BY id DESC";

    		$cmd = Yii::$app->db->createCommand($query)->queryAll();
      		return $cmd;

      		}
      }

      public static function getSchoolUserMainPage() {
            
            if(isset($_GET['id'])) {
              $id = (int)$_GET['id'];
              $query = "SELECT * FROM user 
                          LEFT JOIN organisation ON  organisation.id = user.school
                          WHERE user.id = $id";
              $sql =  Yii::$app->db->createCommand($query)->queryOne();
              return $sql;
            }
            else {
              $id = Yii::$app->user->identity->id;
              $query = "SELECT * FROM user 
                          LEFT JOIN organisation ON  organisation.id = user.school
                          WHERE user.id = $id";
              $sql =  Yii::$app->db->createCommand($query)->queryOne();
              return $sql;
            }

            
      }

}