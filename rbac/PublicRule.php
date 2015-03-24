<?php
namespace app\rbac;

use yii\rbac\Rule;
use app\models\Note;

class PublicRule extends Rule
{
    public $name = 'isPublic';

    public function execute($userId, $item, $params)
    {
        return isset($params['note']) ? in_array($params['note']->visibility, [Note::VIS_PUBLIC_LISTED, Note::VIS_PUBLIC_UNLISTED], true) : false;
    }
}
