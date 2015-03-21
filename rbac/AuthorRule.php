<?php
namespace app\rbac;

use yii\rbac\Rule;

class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    public function execute($userId, $item, $params)
    {
        return isset($params['note']) ? $params['note']->user_id === $userId : false;
    }
}
