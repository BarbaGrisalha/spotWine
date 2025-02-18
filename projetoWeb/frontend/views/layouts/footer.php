<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<footer class="bg-dark text-light py-4">
    <div class="container">
        <div class="row gap-5  text-center">
            <div class="col-lg-4 col-md-12 text-center">
                <p class="text-secondary mt-4">&copy; 2025 Lucas Siqueira & Altamir Rodrigues. Todos os direitos reservados.</p>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="text-uppercase text-secondary">Conta</h5>
                <nav class="nav flex-column">
                    <?= Html::a('<i class="fas fa-file-invoice fa-lg text-secondary mr-2"></i> Minhas Faturas', ['/account/invoices'], ['class' => 'dropdown-item text-light']) ?>
                    <?= Html::a('<i class="fas fa-key fa-lg text-secondary mr-2"></i> Alterar Password', ['/account/change-password'], ['class' => 'dropdown-item text-light']) ?>
                </nav>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="text-uppercase text-secondary">Navegação</h5>
                <nav class="nav flex-column">
                    <?= Html::a('Vinhos', Url::to(['/product/index']), ['class' => 'nav-item nav-link text-light']) ?>
                    <?= Html::a('Produtores', Url::to(['/producers/index']), ['class' => 'nav-item nav-link text-light']) ?>
                    <?= Html::a('Promoções', Url::to(['/product/index', 'ProductFrontSearch[filter]' => 'promocoes']), ['class' => 'nav-item nav-link text-light']) ?>
                    <?= Html::a('Concurso', Url::to(['/contest/index']), ['class' => 'nav-item nav-link text-light']) ?>
                    <?= Html::a('Blogue', Url::to(['/blog-post/index']), ['class' => 'nav-item nav-link text-light']) ?>
                </nav>
            </div>

        </div>
    </div>
</footer>
