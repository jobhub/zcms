<?php

namespace ZCMS\Core;

use Phalcon\Di as PDI;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher as PDispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface as ModuleDefinitionInterface;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Mvc\View as ZView;
use Phalcon\DiInterface;
use ZCMS\Core\Models\CoreTemplates;

/**
 * Class Base Admin Module
 *
 * @package   ZCMS\Core
 * @since     0.0.1
 */
class ZModule implements ModuleDefinitionInterface
{
    /**
     * @var string
     */
    protected $module;

    /**
     * @var string
     */
    protected $baseControllers;

    /**
     * @var string
     */
    protected $baseModels;

    /**
     * @var string
     */
    protected $baseForms;

    /**
     * @var string
     */
    protected $defaultController;

    /**
     * Instance construct
     *
     * @param string $moduleName
     * @param string $defaultController
     */
    public function __construct($moduleName, $defaultController = 'index')
    {
        global $APP_LOCATION;
        $APP_LOCATION = 'backend';

        //Instance multi languages
        ZTranslate::getInstance();

        $this->module = $moduleName;
        $this->defaultController = $defaultController;
        $this->baseControllers = 'ZCMS\\Backend\\' . ucfirst($this->module) . "\\Controllers";
        $this->baseModels = "ZCMS\\Backend\\" . ucfirst($this->module) . "\\Models";
        $this->baseForms = "ZCMS\\Backend\\" . ucfirst($this->module) . "\\Forms";
        //$this->setTemplateDefault();
    }

    /**
     * Register auto loaders
     *
     * @param DiInterface $dependencyInjector
     */
    public function registerAutoLoaders(DiInterface $dependencyInjector = null)
    {
        $loader = new Loader();
        $loader->registerNamespaces([
            $this->baseControllers => APP_DIR . "/backend/" . $this->module . "/controllers/",
            $this->baseModels => APP_DIR . "/backend/" . $this->module . "/models/",
            $this->baseForms => APP_DIR . "/backend/" . $this->module . "/forms/",
        ]);
        $loader->register();
    }

    /**
     * Set default template
     */
    protected final function setTemplateDefault()
    {
        $config = PDI::getDefault()->get("config");
        /**
         * @var CoreTemplates $templateDefault
         */
        $templateDefault = CoreTemplates::findFirst("published = 1 AND location = \"backend\"");
        if ($templateDefault) {
            $config->backendTemplate->defaultTemplate = $templateDefault->base_name;
            PDI::getDefault()->set("config", $config);
        }
    }

    /**
     * Register services
     *
     * @param DiInterface $di
     */
    public final function registerServices(DiInterface $di)
    {
        $module = $this->module;
        $baseControllers = $this->baseControllers;

        //Registering a dispatcher
        $di->set('dispatcher', function () use ($di, &$module, &$baseControllers) {

            //Create new Dispatcher
            $dispatcher = new PDispatcher();

            //Set default namespace to this module
            $dispatcher->setModuleName($this->module);

            //Set default namespace
            $dispatcher->setDefaultNamespace($baseControllers);

            //Set default controller
            $dispatcher->setDefaultController($this->defaultController);

            /**
             * Get Event Manager
             *
             * @var \Phalcon\Events\Manager $eventsManager
             */
            $eventsManager = $di->getShared('eventsManager');

            //Attach acl in dispatcher
            $eventsManager->attach('dispatch', $di->get('acl'));

            //Set event manager
            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        });

        //Register the view component
        $di->set('view', function () use ($di, &$module) {

            //Create Phalcon\Mvc\View
            $view = new ZView();

            $template = new ZTemplate($this->module);

            //Attach event
            $eventsManager = $di->getShared('eventsManager');
            if (method_exists($eventsManager, 'attach')) {
                $eventsManager->attach('view:beforeRender', $template);
                $eventsManager->attach('view:afterRender', $template);
                $eventsManager->attach('view:beforeRenderView', $template);
            } else {
                die(__FILE__ . ' Error: ZCMS cannot render template');
            }

            //Set view Event
            $view->setEventsManager($eventsManager);

            //Set view dir
            $view->setViewsDir(APP_DIR . '/backend/' . $module . '/views/');

            //Register engines
            $view->registerEngines([
                '.volt' => function ($view, $di) {
                    $volt = new Volt($view, $di);

                    $volt->setOptions([
                        'compiledPath' => function ($templatePath) {
                            $templatePath = strstr($templatePath, '/app');
                            $dirName = dirname($templatePath);

                            if (!is_dir(ROOT_PATH . '/cache/volt' . $dirName)) {
                                mkdir(ROOT_PATH . '/cache/volt' . $dirName, 0755, TRUE);
                            }
                            return ROOT_PATH . '/cache/volt' . $dirName . '/' . basename($templatePath, '.volt') . '.php';
                        },
                        'compileAlways' => method_exists($di, 'get') ? (bool)($di->get('config')->backendTemplate->compileTemplate) : false
                    ]);
                    $compiler = $volt->getCompiler();
                    $compiler->addFunction('get_sidebar', 'get_sidebar');
                    $compiler->addFunction('__', '__');
                    $compiler->addFunction('strtotime', 'strtotime');
                    $compiler->addFunction('human_timing', 'human_timing');
                    $compiler->addFunction('moneyFormat', 'moneyFormat');
                    $compiler->addFunction('number_format', 'number_format');
                    $compiler->addFunction('change_date_format', 'change_date_format');
                    $compiler->addFunction('in_array', 'in_array');
                    return $volt;
                }
            ]);

            return $view;
        }, true);
    }
}