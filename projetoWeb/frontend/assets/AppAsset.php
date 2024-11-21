<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '@web/css/style.css',
    ];
    public $js = [
        '@web/js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];

    public function init()
    {
        parent::init();

        // Adicionar timestamp ao CSS para evitar cache
        foreach ($this->css as &$cssFile) {
            $cssFile .= '?v=' . @filemtime(\Yii::getAlias($this->basePath) . '/' . $cssFile);
        }
    }
}
