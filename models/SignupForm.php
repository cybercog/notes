<?php
namespace app\models;

use Yii;
use app\models\User;
use yii\base\Model;

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
            ['name', 'string', 'max' => 60],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'string', 'max' => 255],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Пользователь с таким почтовым адресом уже существует.'],

            ['password', 'required'],
            ['password', 'string', 'max' => 255]
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
            $user->save(false);

            Yii::$app->authManager->assign(Yii::$app->authManager->getRole('user'), $user->getId());

            return $user;
        }

        return null;
    }
}
