<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    public function rules()
    {
        return [
            [['name', 'email', 'subject', 'body'], 'required'],

            ['email', 'email'],

            ['verifyCode', 'captcha']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'email' => 'Ваш электронный адрес',
            'subject' => 'Тема сообщения',
            'body' => 'Сообщение',
            'verifyCode' => 'Код подтверждения'
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            return true;
        } else {
            return false;
        }
    }
}
