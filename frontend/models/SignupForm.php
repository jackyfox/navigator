<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User; 

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $phone_number;

    public $first_name;
    public $last_name;
    public $patronymic;
    
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
            'patronymic' => 'Отчество'
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
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;

    }

}
