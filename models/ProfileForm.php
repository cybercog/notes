<?php
namespace app\models;

use Yii;
use yii\base\Model;

class ProfileForm extends Model
{
    public $name;
    public $email;
    public $password;

    public function attributeLabels()
    {
        return [
            'email' => 'Адрес электронной почты',
            'name' => 'Имя',
            'password' => 'Пароль'
        ];
    }

    public function rules()
    {
        return [
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'required'],
            ['name', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Пользователь с таким именем уже существует.', 'when' => function($model) {
                return $model->name !== Yii::$app->user->identity->name;
            }],
            ['name', 'string', 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Пользователь с таким почтовым адресом уже существует.', 'when' => function($model) {
                return $model->email !== Yii::$app->user->identity->email;
            }],

            ['password', 'safe']
        ];
    }

    public function editUser($user)
    {
        if ($this->validate()) {
            $user->name = $this->name;
            $user->email = $this->email;
            if ($this->password !== '') {
                $user->setPassword($this->password);
            }
            $user->generateAuthKey();

            return $user->save(false);
        }

        return false;
    }
}
