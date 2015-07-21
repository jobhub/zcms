<?php

namespace ZCMS\Core;

use Phalcon\DI;
use ZCMS\Core\Cache\ZCache;
use Phalcon\Mvc\Application as PhalconApplication;

/**
 * Class ZApplication
 *
 * @package ZCMS\Application
 * @property
 */
class ZApplication extends PhalconApplication
{
    use ZApplicationInit;

    /**
     * Cache module key
     */
    const ZCMS_APPLICATION = 'ZCMS_APPLICATION';

    /**
     * Cache modules key
     */
    const ZCMS_APPLICATION_CACHE_MODULES = 'ZCMS_APPLICATION_CACHE_MODULES';

    /**
     * @var mixed
     */
    protected $config;

    /**
     * Instance construct
     */
    public function __construct()
    {
        /**
         * Create default DI
         */
        $this->di = new DI\FactoryDefault();
        $this->config = ZFactory::config();
        if ($this->config->website->baseUri == '') {
            if ($_SERVER['SERVER_PORT'] != '443') {
                $this->config->website->baseUri = 'http://' . $_SERVER['HTTP_HOST'] . str_replace('/public/index.php', '', $_SERVER['SCRIPT_NAME']);
            } else {
                $this->config->website->baseUri = 'https://' . $_SERVER['HTTP_HOST'] . str_replace('/public/index.php', '', $_SERVER['SCRIPT_NAME']);
            }

        }
        $this->di->set('config', $this->config);
        /**
         * @define bool DEBUG
         */
        define('DEBUG', $this->config->debug);

        /**
         * @define string BASE_URI
         */
        define('BASE_URI', $this->config->website->baseUri);
        include ROOT_PATH . '/app/libraries/Core/Utilities/ZFunctions.php';

        parent::__construct($this->di);
    }

    /**
     * Run application
     */
    public function run()
    {
        $this->_initLoader($this->_dependencyInjector);

        $this->_initServices($this->_dependencyInjector, $this->config);

        $this->_initModule();
    }

    /**
     * Auto load module from database
     */
    public function _initModule()
    {

        $cache = ZCache::getInstance(self::ZCMS_APPLICATION);
        $registerModules = $cache->get(self::ZCMS_APPLICATION_CACHE_MODULES);
        if ($registerModules === null) {
            /**
             * @var \Phalcon\Db\Adapter\Pdo\Postgresql $db
             */
            $db = $this->getDI()->get('db');
            $query = "SELECT base_name, class_name, path FROM core_modules WHERE published = 1";
            $modules = $db->fetchAll($query);
            $registerModules = [];
            foreach ($modules as $module) {
                $registerModules[$module['base_name']] = [
                    'className' => $module['class_name'],
                    'path' => APP_DIR . $module['path']
                ];
            }
            $cache->save('REGISTER_MODULES', $registerModules);
        }
        $this->registerModules($registerModules);
    }
}
