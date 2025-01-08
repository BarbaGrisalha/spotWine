<?php

namespace common\rbac;

use Yii;
use yii\rbac\Rule;

class OwnPostRule extends Rule
{
    public $name = 'isOwnPost';

    public function execute($userId, $item, $params)
    {
        return isset($params['post']) && $params['post']->user_id == $userId;
    }

}

