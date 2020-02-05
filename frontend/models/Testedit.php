<?php

namespace frontend\models;
use Yii;

class Testedit extends \yii\db\ActiveRecord {
      
      public $sliderTest;

      public function rules() {
       
        return [
            #[['imageFileEvent'], 'file', 'maxFiles' => 1],
            [['sliderTest'], 'file', 'maxFiles' => 10],

        ];

      }

      public static function tableName()
      {
             return 'test'; // Имя таблицы в БД в которой хранятся записи блога
      }

      public static function getFullTest()
      {           
        if(isset($_GET['idTest'])) {
              $id = (int)$_GET['idTest'];
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


      public static function getOrg() {
      	if(isset($_GET['idTest'])) {
      		$id = (int)$_GET['idTest'];
      		$query = "SELECT * FROM organisation_has_test LEFT JOIN organisation ON organisation.id = organisation_has_test.id_org WHERE id_test = $id";
      		$cmd = Yii::$app->db->createCommand($query)->queryAll();
      		return $cmd;
      	}
      }

      public static function getSlider() {
      	if(isset($_GET['idTest'])) {
      		$id = (int)$_GET['idTest'];
      		$query = "SELECT * FROM slider_test WHERE id_test = $id";
      		$cmd = Yii::$app->db->createCommand($query)->queryAll();
      		return $cmd;
      	}
      }

       public function uploadSliderTest($id) {
    
      
        if ($this->validate()) { 
          
          if(file_exists('upload/tests/'.$id)) {

          }
          else {
            $path = 'upload/tests/'.$id;
            mkdir($path,0775,true);
            #FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
          }


          
            foreach ($this->sliderTest as $fileSliderTest) {
              if(file_exists('upload/tests/'.$id.'/slider')) {
                $path = 'upload/tests/'.$id.'/slider';
                  $fileSliderTest->saveAs($path .'/'. $fileSliderTest->baseName . '.' . $fileSliderTest->extension);

                  $img = $path .'/'. $fileSliderTest->baseName . '.' . $fileSliderTest->extension;

                  $query = "INSERT INTO slider_test (id_test,img) VALUES ('$id','$img')";
                  $cmd = Yii::$app->db->createCommand($query)->execute();
                  
              }
              else {
                $path = 'upload/tests/'.$id.'/slider';
              #FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
               mkdir($path,0775,true);
              $fileSliderTest->saveAs($path .'/'. $fileSliderTest->baseName . '.' . $fileSliderTest->extension);

              
              $img = $path .'/'. $fileSliderTest->baseName . '.' . $fileSliderTest->extension;

            $query = "INSERT INTO slider_test (id_test,img) VALUES ('$id','$img')";
                  $cmd = Yii::$app->db->createCommand($query)->execute();
              }
              
            
            }
           
            return true;

        } else {
            return false;
        }
    }
}