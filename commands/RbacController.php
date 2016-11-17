<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\rbac\UserGroupRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAllRules();

        // add "usersManagement" permission
        $usersManagement = $auth->createPermission('users.management');
        $usersManagement->description = 'Manage users';
        $auth->add($usersManagement);

        // add "postsManagement" permission
        $postsManagement = $auth->createPermission('posts.management');
        $postsManagement->description = 'Manage posts';
        $auth->add($postsManagement);

        // add "notificationManagement" permission
        $notificationManagement = $auth->createPermission('notification.management');
        $notificationManagement->description = 'Manage a notification';
        $auth->add($notificationManagement);

        // add "user" role
        $user = $auth->createRole('user');
        $auth->add($user);

        // add "author" role
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $postsManagement);

        // add "administrator" role
        $administrator = $auth->createRole('administrator');
        $auth->add($administrator);
        $auth->addChild($administrator, $usersManagement);
        $auth->addChild($administrator, $author);
        $auth->addChild($administrator, $notificationManagement);

    }
}