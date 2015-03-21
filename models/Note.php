<?php

namespace app\models;

use yii\db\ActiveRecord;

class Note extends ActiveRecord
{
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 255],

            ['description', 'string', 'max' => 5000],

            ['public', 'required'],
            ['public', 'default', 'value' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
            'public' => 'Видна всем'
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
