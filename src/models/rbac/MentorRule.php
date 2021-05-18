<?php
namespace app\rbac;

use yii\rbac\Rule;


class MentorRule extends Rule
{
    public $name = 'Mentor';

    public function execute($user, $item, $params)
    {
        return isset($params['post']) ? $params['post']->createdBy == $user : false;
    }
}