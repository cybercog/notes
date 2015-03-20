<?php
namespace app\models;

use app\models\User;
use yii\base\Model;
use Yii;

class SignupForm extends Model
{
    public $email;
    public $name;
    public $password;

    public function rules()
    {
        return [
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'required'],
            ['name', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Пользователь с таким именем уже существует.'],
            ['name', 'string', 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Пользователь с таким почтовым адресом уже существует.'],

            ['password', 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Адрес электронной почты',
            'name' => 'Ваше имя',
            'password' => 'Пароль'
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();

            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
