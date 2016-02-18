<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
#defined('YII_ENV_DEV') or define('YII_ENV_DEV', 'dev');
defined('YII_ENV_PRO') or define('YII_ENV_PRO', 'pro');

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../../common/config/main-local.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/main-local.php')
);
if (YII_ENV_DEV) {  
    $config['bootstrap'][] = 'gii';  
    $config['modules']['gii'] = 'yii\gii\Module';  
}  
$application = new yii\web\Application($config);
$application->run();
