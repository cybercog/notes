<?php
namespace app\models;

use yii\base\Model;

class UserEdit extends Model
{
    public $name;
    public $_oldName;
    public $email;
    public $_oldEmail;
    public $password;
    public $role;

    public function rules()
    {
        return [
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'required'],
            ['name', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Пользователь с таким именем уже существует.', 'when' => function($model) {
                return $model->name !== $this->_oldName;
            }],
            ['name', 'string', 'max' => 60],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'string', 'max' => 255],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Пользователь с таким почтовым адресом уже существует.', 'when' => function($model) {
                return $model->email !== $this->_oldEmail;
            }],

            ['password', 'string', 'max' => 255],

            ['role', 'in', 'range' => ['user', 'admin']],
            ['role', 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Адрес электронной почты',
            'name' => 'Имя',
            'password' => 'Пароль',
            'role' => 'Роль'
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

            $user->role->item_name = $this->role;
            $user->role->save();
            return $user->save(false);
        }

        return false;
    }
}
