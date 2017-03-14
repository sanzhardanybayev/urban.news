<?php

namespace app\rbac;
use yii\rbac\Rule;
use app\components\utility as Utility;
class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    /**
     * @param string|integer $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
      return \Yii::$app->user->can('createUser') ? true : (isset($params['news']) ? $params['news']->user_id == $user : false);
    }
}