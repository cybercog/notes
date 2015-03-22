<?php
namespace app\rbac;

use yii\rbac\Rule;

class PublicRule extends Rule
{
    public $name = 'isPublic';

    public function execute($userId, $item, $params)
    {
        return isset($params['note']) ? in_array($params['note']->visibility, [1, 2], true) : false;
    }
}
