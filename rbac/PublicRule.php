<?php
namespace app\rbac;

use yii\rbac\Rule;

class PublicRule extends Rule
{
    public $name = 'isPublic';

    public function execute($userId, $item, $params)
    {
        return isset($params['note']) ? $params['note']->public === 1 : false;
    }
}
