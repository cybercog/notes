<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Role extends ActiveRecord
{
    public static function tableName()
    {
        return 'auth_assignment';
    }

    public function attributeLabels()
    {
        return [
            'item_name' => 'Роль'
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
