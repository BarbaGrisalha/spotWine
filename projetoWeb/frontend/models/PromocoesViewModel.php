<?php

namespace frontend\models;

use common\models\Product;
use common\models\Promotions;

class promocoesViewModel extends BaseProductViewModel
{
    public $product;
    public $promotion;
    public function __construct(Product $product)
    {
        parent::__construct($product);
        $this->promotion = $this->getApplicablePromotion();
    }

    private function getApplicablePromotion()
    {
        // Busca a promoção que se aplica ao produto, se houver
        return Promotions::find()
            ->joinWith('products')
            ->where(['promotion_product.product_id' => $this->product->product_id]) // Especifica a tabela
            ->andWhere(['<=', 'start_date', date('Y-m-d')])
            ->andWhere(['>=', 'end_date', date('Y-m-d')])
            ->one();
    }


    public function getFinalPrice()
    {
        if ($this->promotion) {
            if ($this->promotion->discount_type === 'percent') {
                return $this->product->price * (1 - $this->promotion->discount_value / 100);
            } elseif ($this->promotion->discount_type === 'fixed') {
                return max(0, $this->product->price - $this->promotion->discount_value);
            }
        }
        return $this->product->price;
    }

    public function isOnPromotion()
    {
        return $this->promotion !== null;
    }
}