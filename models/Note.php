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

            ['description', 'string', 'max' => 5000]
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание'
        ];
    }
}
