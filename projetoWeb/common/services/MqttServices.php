<?php
namespace common\services;

require_once __DIR__ . '/../../mosquitto/phpMQTT.php'; // Caminho relativo ao MqttServices.php
use mosquitto\phpMQTT;

class MqttServices
{
    public static function FazPublishNoMosquitto($canal, $msg)
    {
        $server = "test.mosquitto.org";
        $port = 1883;
        $username = "";
        $password = "";
        $client_id = uniqid("spotwine_"); // ID único para evitar conflitos

        $mqtt = new phpMQTT($server, $port, $client_id);
        if ($mqtt->connect(true, NULL, $username, $password)) {
            $mqtt->publish($canal, $msg, 0); // Publica no canal
            $mqtt->close();                 // Fecha a conexão
        } else {
            file_put_contents("debug.output", "Conexão com o broker falhou.");
        }
    }
}
