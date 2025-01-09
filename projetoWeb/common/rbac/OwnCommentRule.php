<?php

namespace common\rbac;

use yii\rbac\Rule;

class OwnCommentRule extends Rule
{
    public $name = 'isOwnComment';

    public function execute($user, $item, $params)
    {
        return isset($params['comment']) && $params['comment']->user_id == $user;
    }
}