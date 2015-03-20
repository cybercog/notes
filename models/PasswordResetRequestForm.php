<?php
namespace app\models;

use app\models\User;
use yii\base\Model;

class PasswordResetRequestForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\app\models\User',
                'message' => 'Пользователя с таким адресом электронной почты не существует.'
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Адрес электронной почты'
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne(['email' => $this->email]);

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {
                return \Yii::$app->mailer->compose(['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['user' => $user])
                    ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' (робот)'])
                    ->setTo($this->email)
                    ->setSubject('Сброс пароля для сайта ' . \Yii::$app->name)
                    ->send();
            }
        }

        return false;
    }
}
