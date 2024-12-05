<?php use yii\helpers\Html;

foreach ($produtosMaisVendidos as $orderItem): ?>
    <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
        <div class="product-item bg-light mb-4">
            <div class="product-img position-relative overflow-hidden">
                <?= Html::img('@web/img/wineBottle.png', [
                    'class' => 'img-fluid w-100',
                    'alt' => 'Imagem garrafa de vinho'
                ]) ?>
                <div class="product-action">
                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                    <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                </div>
            </div>

            <div class="text-center py-4">
                <div class="d-flex align-items-center justify-content-center mt-2">
                    <small>
                        <?= Html::encode($orderItem->product->producers->winery_name ?? 'Sem produtor') ?>
                    </small>
                </div>
                <a class="h6 text-decoration-none text-truncate" href="#">
                    <?= Html::encode($orderItem->product->name ?? 'Produto sem nome') ?>
                </a>
                <div class="d-flex align-items-center justify-content-center mt-2">
                    <h5>
                        <?= Html::encode('€ ' . number_format($orderItem->unit_price, 2, ',', '.')) ?>
                    </h5>
                </div>
                <div class="d-flex align-items-center justify-content-center mb-1">
                    <small class="fa fa-star text-primary mr-1"></small>
                    <small class="fa fa-star text-primary mr-1"></small>
                    <small class="fa fa-star text-primary mr-1"></small>
                    <small class="fa fa-star text-primary mr-1"></small>
                    <small class="fa fa-star-half-alt text-primary mr-1"></small>
                    <small>(99)</small>
                </div>

            </div>
        </div>
    </div>
<?php endforeach; ?>
