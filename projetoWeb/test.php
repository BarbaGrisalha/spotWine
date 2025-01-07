<?php

require_once 'mosquitto/phpMQTT.php';
require_once 'common/services/MqttServices.php';

use common\services\MqttServices;

// Publica uma mensagem de teste
$canal = "spotwine/teste";
$mensagem = json_encode([
    'titulo' => 'Nova Promoção!',
    'descricao' => 'Aproveite 20% de desconto nos melhores vinhos!',
]);

MqttServices::FazPublishNoMosquitto($canal, $mensagem);

echo "Mensagem publicada no canal $canal.\n";
