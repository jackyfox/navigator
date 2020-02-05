<?php

namespace frontend\models;
use Yii;

class ProfFavorite extends \yii\db\ActiveRecord {

	  public static function tableName()
      {
             return 'profile_favorite_profession'; // Имя таблицы в БД в которой хранятся записи блога
      }
}


echo "good";