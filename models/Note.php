<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Note extends ActiveRecord
{
    const VIS_PRIVATE = 0;
    const VIS_PUBLIC_LISTED = 1;
    const VIS_PUBLIC_UNLISTED = 2;

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public static function tableName()
    {
        return 'note';
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 60],

            ['description', 'string', 'max' => 1000],

            ['visibility', 'required'],
            ['visibility', 'integer'],
            ['visibility', function ($attribute, $params) {
                if ( !(Yii::$app->user->isGuest && in_array($this->$attribute, [self::VIS_PUBLIC_LISTED, self::VIS_PUBLIC_UNLISTED]) || !Yii::$app->user->isGuest && in_array($this->$attribute, [self::VIS_PUBLIC_LISTED, self::VIS_PUBLIC_UNLISTED, self::VIS_PRIVATE]))) {
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
            'visibility' => 'Видимость',
            'created_at' => 'Дата создания'
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
