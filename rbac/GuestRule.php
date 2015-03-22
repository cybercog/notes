<?php
namespace app\rbac;

use yii\rbac\Rule;

class GuestRule extends Rule
{
    public $name = 'isGuest';

    public function execute($userId, $item, $params)
    {
        return Yii::$app->user->isGuest;
    }
}
