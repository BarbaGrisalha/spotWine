<?php

    namespace backend\modules\api;

    /**
     * api module definition class
     */
    class ModuleAPI extends \yii\base\Module
    {
        /**
         * {@inheritdoc}
         */
        public $controllerNamespace = 'backend\modules\api\controllers';

        /**
         * {@inheritdoc}
         */
        public function init()
        {
            parent::init();

            // custom initialization code goes here
            parent::init();
            \Yii::$app->user->enableSession = false;

            // Faz a conversão para JSON
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        }
    }
