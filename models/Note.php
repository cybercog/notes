<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Note extends ActiveRecord
{
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 255],

            ['description', 'string', 'max' => 5000],

            ['visibility', 'required'],
            ['visibility', 'integer'],
            ['visibility', 'default', 'value' => 1],
            ['visibility', function ($attribute, $params) {
                if ( !(Yii::$app->user->isGuest && in_array($this->$attribute, [1, 2]) || !Yii::$app->user->isGuest && in_array($this->$attribute, [0, 1, 2]))) {
                    $this->addError($attribute, 'Недопустимый уровень видимости.' . $this->$attribute);
                }
            }]
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
            'visibility' => 'Видимость'
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
