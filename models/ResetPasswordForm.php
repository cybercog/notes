<?php
namespace app\models;

use app\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

class ResetPasswordForm extends Model
{
    public $password;

    /**
     * @var \app\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param  string                          $token
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if ($token === '') {
            throw new InvalidParamException('Токен для сброса пароля не может быть пустым');
        }

        if (!$this->_user = User::findByPasswordResetToken($token)) {
            throw new InvalidParamException('Неправильный токен сброса пароля');
        }

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => 'Новый пароль'
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        $user->save();

        return Yii::$app->user->login($user, 3600 * 24 * 30);
    }
}
