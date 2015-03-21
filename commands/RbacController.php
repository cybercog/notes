<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;


        //Rules
        $authorRule = new \app\rbac\AuthorRule;
        $auth->add($authorRule);

        $publicRule = new \app\rbac\PublicRule;
        $auth->add($publicRule);


        //Permissions
        $viewNote = $auth->createPermission('viewNote');
        $viewNote->description = 'View note';
        $auth->add($viewNote);

        $viewOwnNote = $auth->createPermission('viewOwnNote');
        $viewOwnNote->description = 'View own note';
        $viewOwnNote->ruleName = $authorRule->name;
        $auth->add($viewOwnNote);
        $auth->addChild($viewOwnNote, $viewNote);

        $viewPublicNote = $auth->createPermission('viewPublicNote');
        $viewPublicNote->description = 'View public note';
        $viewPublicNote->ruleName = $publicRule->name;
        $auth->add($viewPublicNote);
        $auth->addChild($viewPublicNote, $viewNote);

        $createNote = $auth->createPermission('createNote');
        $createNote->description = 'Create note';
        $auth->add($createNote);

        $updateNote = $auth->createPermission('updateNote');
        $updateNote->description = 'Update note';
        $auth->add($updateNote);

        $updateOwnNote = $auth->createPermission('updateOwnNote');
        $updateOwnNote->description = 'Update own note';
        $updateOwnNote->ruleName = $authorRule->name;
        $auth->add($updateOwnNote);
        $auth->addChild($updateOwnNote, $updateNote);

        $removeNote = $auth->createPermission('removeNote');
        $removeNote->description = 'Remove note';
        $auth->add($removeNote);

        $removeOwnNote = $auth->createPermission('removeOwnNote');
        $removeOwnNote->description = 'Remove own note';
        $removeOwnNote->ruleName = $authorRule->name;
        $auth->add($removeOwnNote);
        $auth->addChild($removeOwnNote, $removeNote);


        //Roles
        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $viewOwnNote);
        $auth->addChild($user, $viewPublicNote);
        $auth->addChild($user, $createNote);
        $auth->addChild($user, $updateOwnNote);
        $auth->addChild($user, $removeOwnNote);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $viewNote);
        $auth->addChild($admin, $updateNote);
        $auth->addChild($admin, $removeNote);
        $auth->addChild($admin, $user);
    }
}
