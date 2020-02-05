<?php
namespace frontend\models;

use Yii;

use yii\base\Model;
use common\models\User; 

/**
 * Signup form
 */
class TeachersigForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $phone_number;

    public $first_name;
    public $last_name;
    public $patronymic;
    public $myOrganisation;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Данный логин уже используется в системе'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Данный email уже используется в системе'],

            ['phone_number', 'string', 'max' => 255],
            ['phone_number', 'trim'],
            ['phone_number', 'required'],
            ['phone_number', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Данный телефон уже используется в системе'],


            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            [['first_name','last_name','patronymic','myOrganisation'], 'required'],
            ['first_name', 'string', 'max' => 255],
            ['last_name', 'string', 'max' => 255],
            ['patronymic', 'string', 'max' => 50],
        ];
    }

        /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'Адрес электронной почты',
            'phone_number' => 'Номер телефона',
            'password' => 'Пароль',

            'first_name' => 'Фамилия',
            'last_name' => 'Имя',
            'patronymic' => 'Отчество',
            'myOrganisation' => 'Организация'
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->phone_number = $this->phone_number;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->patronymic = $this->patronymic;
        $user->school = $this->myOrganisation;
        $user->setPassword($this->password);
        $user->generateAuthKey();

            #print_r($sqlGet);
            $past = $user->save();
            
            if ($past) {
                $query = "INSERT INTO `user_has_group`(`user_id`, `group_id`) VALUES ($user->id,3)";
                Yii::$app->db->createCommand($query)->execute();

                $query2 = "INSERT INTO `organisation_has_personality`(`organisation_id`, `personality_id`, `type_personality`) VALUES ($this->myOrganisation,$user->id,1)";
                Yii::$app->db->createCommand($query2)->execute();
            }

            return $past ? $user : null;
        
    }
    public static function getSchoolOrganisation() {
        $query = "SELECT id,name FROM organisation_has_type 
              LEFT JOIN organisation ON  organisation.id = organisation_has_type.organisation_id
              WHERE type_id IN(5)";
        $sql =  Yii::$app->db->createCommand($query)->queryAll();
        return $sql;
    }
}
