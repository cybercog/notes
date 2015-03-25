<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Comment extends ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    public function attributeLabels()
    {
        return [
            'message' => 'Сообщение'
        ];
    }

    public function rules()
    {
        return [
            ['message', 'string', 'max' => 255]
        ];
    }

    public function getNote()
    {
        return $this->hasOne(Note::className(), ['id' => 'note_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
