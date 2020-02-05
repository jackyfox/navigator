<?php

namespace frontend\models;
use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\data\ArrayDataProvider;
class Mycompany extends \yii\db\ActiveRecord {

    public static function tableName()
    {
        return 'organisation'; // Имя таблицы в БД в которой хранятся записи блога
    }


    public $imageFiles;
    public $bgCompany;
    public $idCompany;
    public $nameCompany;
    public $aboutCompany;
    public $slider;
    public $videoCompany;

    public $idCompanyForEvent;
    public $imageFileEvent;
    public $nameEvent;
    public $event_time;
    public $aboutEvent;
    public $addrEvent;
    public $sliderEvent;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'extensions' => 'png, jpg', 'maxFiles' => 1],
            [['bgCompany'], 'file', 'maxFiles' => 1],
            [['slider'], 'file', 'maxFiles' => 10],
            [['imageFileEvent'], 'file', 'maxFiles' => 1],
           	[['sliderEvent'], 'file', 'maxFiles' => 10],

        ];
    }
    
    public function upload($id)
    {	

        if ($this->validate()) { 
        	
        	if(file_exists('upload/organisation/'.$id)) {

        	}
        	else {
        		$path = 'upload/organisation/'.$id;
        		FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
        	}


            
            	if(file_exists('upload/organisation/'.$id.'/logo')) {
            		$path = 'upload/organisation/'.$id.'/logo';
            		
            		foreach (glob($path.'/*') as $file) {
            			unlink($file);
        			}

        			$this->imageFiles->saveAs($path .'/'.  $this->imageFiles->baseName. '.' . $this->imageFiles->extension);


		    		$img = $path .'/'.  $this->imageFiles->baseName. '.' . $this->imageFiles->extension;
		    		$sql = "UPDATE organisation SET logo = '$img' WHERE id = '$id'";
		    		
		    		Yii::$app->db->createCommand($sql)->execute();
        		}
        		else {
        			$path = 'upload/organisation/'.$id.'/logo';

        			foreach (glob($path.'/*') as $file) {
            			unlink($file);
        			}
        			
        			FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
        		
        			$this->imageFiles->saveAs($path .'/'.  $this->imageFiles->baseName. '.' . $this->imageFiles->extension);

        			$img = $path .'/'.  $this->imageFiles->baseName. '.' . $this->imageFiles->extension;
		    		$sql = "UPDATE organisation SET logo = '$img' WHERE id = '$id'";
		    		
		    		Yii::$app->db->createCommand($sql)->execute();

        		}
               
            


            return true;

        } else {
            return false;
        }
    }

    public function uploadBg($id) {

    	if ($this->validate()) { 
        	
        	if(file_exists('upload/organisation/'.$id)) {

        	}
        	else {
        		$path = 'upload/organisation/'.$id;
        		FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
        	}      	

           
               if(file_exists('upload/organisation/'.$id.'/bg')) {
               		

               		$path = 'upload/organisation/'.$id.'/bg';
               		
               		foreach (glob($path.'/*') as $file) {
            			unlink($file);
        			}

        			 $this->bgCompany->saveAs($path .'/'. $this->bgCompany->baseName . '.' . $this->bgCompany->extension);

        			$img = $path .'/'.  $this->bgCompany->baseName. '.' . $this->bgCompany->extension;
		    		$sql = "UPDATE organisation SET img = '$img' WHERE id = '$id'";
		    		
		    		Yii::$app->db->createCommand($sql)->execute();
        		}
        		else {
        			$path = 'upload/organisation/'.$id.'/bg';

        			foreach (glob($path.'/*') as $file) {
            			unlink($file);
        			}

        			FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
        		
        			$this->bgCompany->saveAs($path .'/'. $this->bgCompany->baseName . '.' . $this->bgCompany->extension);

        			$img = $path .'/'.  $this->bgCompany->baseName. '.' . $this->bgCompany->extension;
		    		$sql = "UPDATE organisation SET img = '$img' WHERE id = '$id'";
		    		
		    		Yii::$app->db->createCommand($sql)->execute();
        		}
            
        		
            return true;

        } else {
            return false;
        }
    }

    public function uploadSlider($id) {
    
      
        if ($this->validate()) { 
          
          if(file_exists('upload/organisation/'.$id)) {

            }
            else {
                $path = 'upload/organisation/'.$id;
                FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
            }

            if(!file_exists('upload/organisation/'.$id.'/slider')) {
                $path = 'upload/organisation/'.$id.'/slider';
                FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
                $fileSlider->saveAs($path .'/'. $name_file . '.' . $fileSlider->extension);

            }


          
            foreach ($this->slider as $fileSlider) {
 
                $path = 'upload/organisation/'.$id.'/slider';
                  $fileSlider->saveAs($path .'/'. $fileSlider->baseName . '.' . $fileSlider->extension);

                  $img = $path .'/'. $fileSlider->baseName . '.' . $fileSlider->extension;

                  $query = "INSERT INTO slider_org (id_org,img_org) VALUES ('$id','$img')";
                  $cmd = Yii::$app->db->createCommand($query)->execute();
                  
              
            
            }
           
            return true;

        } else {
            return false;
        }
    }

    public static function getCompanyInfo() {
 	  if (Yii::$app->user->isGuest) { } else { 
        if(isset($_GET['id'])) {
            $id_org = (int)$_GET['id'];
            $id_user = Yii::$app->user->identity->id;

            $query = "SELECT organisation_has_personality.organisation_id,organisation_has_personality.personality_id,organisation_has_personality.type_personality, organisation.name, organisation.id as org_id,organisation.name as org_name, organisation.description,organisation.img ,organisation.logo, organisation_has_type.type_id, type.id as type_id , type.name as type_name,organisation.video as video
FROM organisation_has_personality
LEFT JOIN organisation ON organisation.id = organisation_has_personality.organisation_id 
LEFT JOIN organisation_has_type ON organisation_has_type.organisation_id = organisation_has_personality.organisation_id
LEFT JOIN type ON type.id = organisation_has_type.type_id 
WHERE organisation_has_personality.personality_id = $id_user AND organisation_has_personality.organisation_id = $id_org";
	
            $cmd = Yii::$app->db->createCommand($query)->queryOne();
            if(empty($cmd)) {
                return FALSE;
            }
            else {
                return $cmd;
            }
        }
        else {
            return FALSE;
        }    
       }    
    }

    public static function getSlideImg() {
    	if(isset($_GET['id'])) {
    		$id_org = (int)$_GET['id'];

    		$query = "SELECT * FROM `slider_org` WHERE id_org = '$id_org'";
    		$cmd = Yii::$app->db->createCommand($query)->queryAll();
    		
    		if(empty($cmd)) {
    			return FALSE;
    		}
    		else {
    			return $cmd;
    		}
    	}
    }

    public function updateInfoCompany($id,$companyName,$companyAbout,$companyId,$videoCompany) {
    	if(!empty($companyName) && !empty($companyAbout) && !empty($companyId)) {

    		$sql = "UPDATE organisation SET name = '$companyName', description = '$companyAbout', video = '$videoCompany' WHERE id = '$companyId'";
    		
    		Yii::$app->db->createCommand($sql)->execute();
    	}
    	else {
    		echo "bad";
    	}
    }

    public function eventCompany() {
    	if(isset($_GET['id'])) {
    		$id_org = (int)$_GET['id'];

    		$query = "SELECT * FROM `event_has_organisation` 
    				  LEFT JOIN  event ON event.id = event_has_organisation.id_event 
    				  WHERE id_org = '$id_org'";
    		$cmd = Yii::$app->db->createCommand($query)->queryAll();


			$dataProvider= new ArrayDataProvider([
			    'allModels' => Yii::$app->db->createCommand($query)->queryAll(),
			    'pagination' => false,
			]);
    		
    		if(empty($cmd)) {
    			return FALSE;
    		}
    		else {
    			return $dataProvider;
    		}
    	}
    }


    public function createEvent($nameEvent,$event_time,$aboutEvent,$idCompanyForEvent,$addrEvent) {

    		if(!empty($nameEvent) && !empty($event_time) && !empty($aboutEvent) && !empty($idCompanyForEvent)) {
    		
    			$insert_event = "INSERT INTO event (title,description,event_time) VALUES ('$nameEvent','$aboutEvent','$event_time')";
    			
               	$cmd_insert_event = Yii::$app->db->createCommand($insert_event)->execute();
               	$id_event = Yii::$app->db->getLastInsertID();

               	if(!empty($id_event)) {
	               	$insert_has_addr = "INSERT INTO event_has_address (event_id,address_id) VALUES ('$id_event','$addrEvent')";
	            	$cmd_insert_has_addr = Yii::$app->db->createCommand($insert_has_addr)->execute();

	               	$insert_has_org = "INSERT INTO event_has_organisation (id_org,id_event) VALUES ('$idCompanyForEvent','$id_event')";
	               	$cmd_insert_has_org = Yii::$app->db->createCommand($insert_has_org)->execute();
               	}
            	
    		}
    		else {
    			echo "bad";
    		}
    	
    }

    public function uploadPerwieEvent($id) {

    	$query = "SELECT * FROM event_has_organisation WHERE id_org = $id ORDER BY id DESC LIMIT 1";
    	$cmd = Yii::$app->db->createCommand($query)->queryOne();
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
    	$query = "SELECT * FROM event_has_organisation WHERE id_org = $id ORDER BY id DESC LIMIT 1";
    	$cmd = Yii::$app->db->createCommand($query)->queryOne();
    	$id_event = $cmd['id_event'];
    	
        if ($this->validate()) { 
        	
        	if(file_exists('upload/event/'.$id_event)) {

        	}
        	else {
        		$path = 'upload/event/'.$id_event;
        		FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
        	}


        	
            foreach ($this->sliderEvent as $fileSliderEvent) {
           		if(file_exists('upload/event/'.$id_event.'/slider')) {
           			$path = 'upload/event/'.$id_event.'/slider';
               		$fileSliderEvent->saveAs($path .'/'. $fileSliderEvent->baseName . '.' . $fileSliderEvent->extension);

               		$img = $path .'/'. $fileSliderEvent->baseName . '.' . $fileSliderEvent->extension;

               		$query = "INSERT INTO slider_event (id_event,img) VALUES ('$id_event','$img')";
               		$cmd = Yii::$app->db->createCommand($query)->execute();
               		
            	}
            	else {
            		$path = 'upload/event/'.$id_event.'/slider';
        			FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
        			$fileSliderEvent->saveAs($path .'/'. $fileSliderEvent->baseName . '.' . $fileSliderEvent->extension);

        			
        			$img = $path .'/'. $fileSliderEvent->baseName . '.' . $fileSliderEvent->extension;

		    		$query = "INSERT INTO slider_event (id_event,img) VALUES ('$id_event','$img')";
               		$cmd = Yii::$app->db->createCommand($query)->execute();
            	}
        			
        		
            }
           
            return true;

        } else {
            return false;
        }
    }

    public function eventAddrGet() {
    	$query = "SELECT * FROM `address` ORDER BY id";
    	$cmd = Yii::$app->db->createCommand($query)->queryAll();
    	return $cmd;
    }

    public function testsCompany() {
    	if(isset($_GET['id'])) {
    		$id_org = (int)$_GET['id'];

    		$query = "SELECT * FROM test WHERE organisation = '$id_org'";
    		$cmd = Yii::$app->db->createCommand($query)->queryAll();


			$dataProvider= new ArrayDataProvider([
			    'allModels' => Yii::$app->db->createCommand($query)->queryAll(),
			    'pagination' => false,
			]);
    		
    		if(empty($cmd)) {
    			return FALSE;
    		}
    		else {
    			return $dataProvider;
    		}
    	}
    }



    public function blogCompany() {
        if(isset($_GET['id'])) {
            $id_org = (int)$_GET['id'];

            $query = "SELECT blog.title as titleBlog,blog.data as blogData , blog.id as blogID, blog.description as description, blog.img as imgBlog, organisation_has_blog.id_org as id_org FROM organisation_has_blog 
                        LEFT JOIN blog ON blog.id = organisation_has_blog.id_blog 
                        WHERE id_org = $id_org
                        ORDER BY organisation_has_blog.id";
            $cmd = Yii::$app->db->createCommand($query)->queryAll();


            $dataProvider= new ArrayDataProvider([
                'allModels' => Yii::$app->db->createCommand($query)->queryAll(),
                'pagination' => false,
            ]);
            
            if(empty($cmd)) {
                return FALSE;
            }
            else {
                return $dataProvider;
            }
        }
    }



}