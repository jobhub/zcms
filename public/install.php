<?php

error_reporting(E_ALL);

try {
    /**
     * Define useful constants
     */
    define('ROOT_PATH', dirname(__DIR__));
    define('APP_DIR', ROOT_PATH . '/app');
    require_once ROOT_PATH . '/app/config/define.php';
    require_once(ROOT_PATH . '/app/libraries/Core/Utilities/ZFunctions.php');

    if(!file_exists(ROOT_PATH . '/app/install/')){
        die();
    }

    /**
     * Read the configuration
     *
     * @var mixed $config
     */
    $config = new \Phalcon\Config\Adapter\Php(ROOT_PATH . '/app/config/config.php');

    /**
     * Read auto-loader
     */
    include ROOT_PATH . '/app/install/config/loader.php';

    /**
     * Read services
     */
    include ROOT_PATH . '/app/install/config/services.php';

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo $e->getMessage();
}
