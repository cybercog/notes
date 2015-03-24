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

        $guestRule = new \app\rbac\GuestRule;
        $auth->add($guestRule);


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

        $updateNote = $auth->createPermission('updateNote');
        $updateNote->description = 'Update note';
        $auth->add($updateNote);

        $updateOwnNote = $auth->createPermission('updateOwnNote');
        $updateOwnNote->description = 'Update own note';
        $updateOwnNote->ruleName = $authorRule->name;
        $auth->add($updateOwnNote);
        $auth->addChild($updateOwnNote, $updateNote);

        $deleteNote = $auth->createPermission('deleteNote');
        $deleteNote->description = 'Delete note';
        $auth->add($deleteNote);

        $deleteOwnNote = $auth->createPermission('deleteOwnNote');
        $deleteOwnNote->description = 'Delete own note';
        $deleteOwnNote->ruleName = $authorRule->name;
        $auth->add($deleteOwnNote);
        $auth->addChild($deleteOwnNote, $deleteNote);

        $viewAdminStatistic = $auth->createPermission('viewAdminStatistic');
        $viewAdminStatistic->description = 'View admin statistic';
        $auth->add($viewAdminStatistic);

        $viewAdminUsers = $auth->createPermission('viewAdminUsers');
        $viewAdminUsers->description = 'View admin users';
        $auth->add($viewAdminUsers);

        $editUser = $auth->createPermission('editUser');
        $editUser->description = 'Edit user';
        $auth->add($editUser);

        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = 'Delete user';
        $auth->add($deleteUser);


        //Roles
        $guest = $auth->createRole('guest');
        $guest->ruleName = $guestRule->name;
        $auth->add($guest);
        $auth->addChild($guest, $viewPublicNote);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $viewOwnNote);
        $auth->addChild($user, $updateOwnNote);
        $auth->addChild($user, $deleteOwnNote);
        $auth->addChild($user, $guest);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $viewNote);
        $auth->addChild($admin, $updateNote);
        $auth->addChild($admin, $deleteNote);
        $auth->addChild($admin, $viewAdminStatistic);
        $auth->addChild($admin, $viewAdminUsers);
        $auth->addChild($admin, $editUser);
        $auth->addChild($admin, $deleteUser);
        $auth->addChild($admin, $user);
    }
}
