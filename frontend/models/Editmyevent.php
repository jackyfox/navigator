<?php

namespace frontend\models;
use Yii;

class Editmyevent extends \yii\db\ActiveRecord {

	#public $imageFileEvent;
	public $sliderEvent;
	public $imageFile;

	 public function rules() {
       
        return [
            #[['imageFileEvent'], 'file', 'maxFiles' => 1],
           	[['sliderEvent'], 'file', 'maxFiles' => 10],
           	[['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg']

        ];

      }

      public static function getEvent()
      {		
      		//$cmd = Yii::$app->db->createCommand("SELECT id,name,img,description, 
      		//	(SELECT type_id FROM organisation_has_type WHERE organisation_id = id AND type_id = 4 AND type_id = 2) AS type_id
      		//	FROM organisation ORDER BY id")->queryAll();

      	if(isset($_GET['OrgID']) && isset($_GET['idEvent'])) {
    		$id_org = (int)$_GET['OrgID'];
    		$id_event = (int)$_GET['idEvent'];
    		$id_user = Yii::$app->user->identity->id;


    		$query_user = "SELECT * FROM organisation_has_personality WHERE personality_id = $id_user AND organisation_id = $id_org";
    		$query_send = Yii::$app->db->createCommand($query_user)->queryOne();

	    		if(!empty($query_send)) {

		    		$query = "SELECT * FROM `event_has_organisation` 
		    				  LEFT JOIN  event ON event.id = event_has_organisation.id_event
		    				  WHERE id_org = '$id_org' AND id_event = $id_event";
		    		$cmd = Yii::$app->db->createCommand($query)->queryOne();

			    		if(empty($cmd)) {
			    			return FALSE;
			    		}

			    		else {
			    			return $cmd;
			    		}
		    	}
		    	else {
		    		die('403');
		    	}
    	}


      }

      public static function getSlide()
      {	
      	if(isset($_GET['OrgID']) && isset($_GET['idEvent'])) {
      		$id_org = (int)$_GET['OrgID'];
    		$id_event = (int)$_GET['idEvent'];
    		$id_user = Yii::$app->user->identity->id;

      		$query = "SELECT * FROM slider_event
		    				  WHERE id_event = $id_event";
		 	$cmd = Yii::$app->db->createCommand($query)->queryAll();

			if(empty($cmd)) {
				return FALSE;
			}

			else {
				return $cmd;
			}
      	}

      }

      public static function getOrg() {
      	if(isset($_GET['idEvent'])) {
      		$id = (int)$_GET['idEvent'];
      		$query = "SELECT * FROM event_has_organisation LEFT JOIN organisation ON organisation.id = event_has_organisation.id_org WHERE id_event = $id";
      		$cmd = Yii::$app->db->createCommand($query)->queryAll();
      		return $cmd;
      	}
      }

      public static function allOrg() {
      	$query = "SELECT * FROM organisation ORDER BY id";
      	$cmd = Yii::$app->db->createCommand($query)->queryAll();
      	return $cmd;
      }

      public static function getAdres() {
       	if(isset($_GET['idEvent'])) {
      		$id = (int)$_GET['idEvent'];
      		$query = "SELECT * FROM event_has_address LEFT JOIN address ON address.id = event_has_address.address_id WHERE event_id = $id";
      		$cmd = Yii::$app->db->createCommand($query)->queryAll();
      		return $cmd;
      	}           
      }

      public static function getAllAdress() {
      	$sql = "SELECT * FROM address ORDER BY id";
      	$cmd = Yii::$app->db->createCommand($sql)->queryAll();
      	return $cmd;
      }

	  public function uploadPerwieEvent($id) {

    
    	$id_event = $cmd['id_event'];

    	if ($this->validate()) { 
        	
        	if(file_exists('upload/event/'.$id_event)) {

        	}
        	else {
        		$path = 'upload/event/'.$id_event;
        		FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
        	}      	

           
               if(file_exists('upload/event/'.$id_event.'/bg')) {

               		$path = 'upload/event/'.$id_event.'/bg';
        			 $this->imageFileEvent->saveAs($path .'/'. $this->imageFileEvent->baseName . '.' . $this->imageFileEvent->extension);

        			$img = $path .'/'.  $this->imageFileEvent->baseName. '.' . $this->imageFileEvent->extension;
		    		$sql = "UPDATE event SET picture = '$img' WHERE id = '$id_event'";
		    		
		    		Yii::$app->db->createCommand($sql)->execute();
        		}
        		else {
        			$path = 'upload/event/'.$id_event.'/bg';
        			FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
        		
        			$this->imageFileEvent->saveAs($path .'/'. $this->imageFileEvent->baseName . '.' . $this->imageFileEvent->extension);

        			$img = $path .'/'.  $this->imageFileEvent->baseName. '.' . $this->imageFileEvent->extension;
		    		$sql = "UPDATE event SET picture = '$img' WHERE id = '$id_event'";
		    		
		    		Yii::$app->db->createCommand($sql)->execute();
        		}
            
        		
            return true;

        } else {
            return false;
        }
    }


    public function uploadSliderEvent($id) {
    
    	
        if (!$this->validate()) { 
        	
        	if(file_exists('upload/event/'.$id)) {

        	}
        	else {
        		$path = 'upload/event/'.$id;
        		mkdir($path,0755);
        		#FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
        	}


        	
            foreach ($this->sliderEvent as $fileSliderEvent) {
           		if(file_exists('upload/event/'.$id.'/slider')) {
           			$path = 'upload/event/'.$id.'/slider';
               		$fileSliderEvent->saveAs($path .'/'. $fileSliderEvent->baseName . '.' . $fileSliderEvent->extension);

               		$img = $path .'/'. $fileSliderEvent->baseName . '.' . $fileSliderEvent->extension;

               		$query = "INSERT INTO slider_event (id_event,img) VALUES ('$id','$img')";
               		$cmd = Yii::$app->db->createCommand($query)->execute();
               		
            	}
            	else {
            		$path = 'upload/event/'.$id.'/slider';
            		mkdir($path,0755);
        			#FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
        			$fileSliderEvent->saveAs($path .'/'. $fileSliderEvent->baseName . '.' . $fileSliderEvent->extension);

        			
        			$img = $path .'/'. $fileSliderEvent->baseName . '.' . $fileSliderEvent->extension;

		    		$query = "INSERT INTO slider_event (id_event,img) VALUES ('$id','$img')";
               		$cmd = Yii::$app->db->createCommand($query)->execute();
            	}
        			
        		
            }
           
            return true;

        } else {
            return false;
        }
    }
}