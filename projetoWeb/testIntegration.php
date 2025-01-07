<?php
require_once __DIR__ . '/common/services/MqttServices.php';

\common\services\MqttServices::FazPublishNoMosquitto('spotwine/promocoes', json_encode([
    'titulo' => 'Promoção Manual!',
    'descricao' => 'Mensagem enviada manualmente para testar integração.',
]));

echo "Mensagem enviada com sucesso!";
