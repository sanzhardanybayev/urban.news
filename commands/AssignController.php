<?php

namespace app\commands;
use Yii;
use yii\console\Controller;
use app\rbac\AuthorRule as AuthorRule;

/**
 * Class AssignController
 * @package app\commands
 */
class AssignController extends Controller
{

    /**
     * This method configures Authorization permissions
     */
    public function actionAddpermissions()
    {
        $auth = Yii::$app->authManager;

        // watchPreview permission is going to be checked  by ifGuest function
        // TODO: Add 3 permissions
        $readFullArticle = $auth->createPermission('readFullArticle');
        $readFullArticle->description = 'Allows to read full article';
        $auth->add($readFullArticle);

        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Allows to create posts';
        $auth->add($createPost);

        $createUser = $auth->createPermission('createUser');
        $createUser->description = 'Allows to add users and edit their profiles';
        $auth->add($createUser);

    }

    /**
     * This method creates Authorization roles
     */
    public function actionAddroles(){

        $auth = Yii::$app->authManager;

        // TODO: add 3 roles

        $registeredUser = $auth->createRole('registeredUser');
        $auth->add($registeredUser);
        $auth->addChild($registeredUser, $auth->getPermission('readFullArticle'));

        $moderator = $auth->createRole('moderator');
        $auth->add($moderator);
        $auth->addChild($moderator, $auth->getPermission('createPost'));
        $auth->addChild($moderator, $registeredUser);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $auth->getPermission('createUser'));
        $auth->addChild($admin, $moderator); // Inheriting permissions from moderator

    }

    /**
     * This method assign role to user
     */
    public function actionSeed(){
        $auth = Yii::$app->authManager;
        $author = $auth->getRole('admin');
        $auth->assign($author, 7);
    }

    public function actionRule(){
        $auth = Yii::$app->authManager;

        // add the rule
        $rule = new AuthorRule();
        $auth->add($rule);

        // add the "updateOwnPost" permission and associate the rule with it.
        $updateOwnPost = $auth->createPermission('updateOwnPost');
        $updateOwnPost->description = 'Update own post';
        $updateOwnPost->ruleName = $rule->name;
        $auth->add($updateOwnPost);

        // "updateOwnPost" will be used from "updatePost"
        $auth->addChild($updateOwnPost, $auth->getPermission('createPost'));

        // allow "author" to update their own posts
        $auth->addChild($auth->getRole('moderator'), $updateOwnPost);
        $auth->addChild($auth->getRole('admin'), $updateOwnPost);
    }

}