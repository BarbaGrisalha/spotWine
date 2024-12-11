<?php
namespace common\rbac;

use yii\rbac\Rule;
class OwnPromotionRule extends Rule
{
    public $name = 'isOwnPromotion'; // Nome da regra

    public function execute($userId, $item, $params)
    {
        // Verifica se o parâmetro 'promotion' foi passado
        if (isset($params['promotion'])) {
            $promotion = $params['promotion'];
            // Verifica se a promoção pertence ao produtor logado
            return $promotion->producer_id === \Yii::$app->user->identity->producers->producer_id;
        }
        return false;
    }
}