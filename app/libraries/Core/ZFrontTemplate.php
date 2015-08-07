<?php

namespace ZCMS\Core;

use Phalcon\Events\Event as PEvent;
use Phalcon\Mvc\View as PView;

/**
 * Class helper loader overwrite template frontend
 *
 * @package   ZCMS\Core
 * @author    ZCMS Team
 * @copyright ZCMS Team
 * @since     0.0.1
 */
class ZFrontTemplate
{
    /**
     * @var string Module name need overwrite template;
     */
    protected $moduleBaseName = '';

    /**
     * Instance construct
     *
     * @param string $moduleBaseName
     */
    public function __construct($moduleBaseName)
    {
        $this->moduleBaseName = $moduleBaseName;
    }

    /**
     * After render
     *
     * @param PEvent $event
     * @param PView $view
     */
    public function afterRender(PEvent $event, PView $view)
    {
        //Do something
    }

    /**
     * Before render view
     *
     * @param PEvent $event
     * @param PView $view
     */
    public function beforeRender(PEvent $event, PView $view)
    {
        $defaultTemplate = $view->getDI()->get('config')->frontendTemplate->defaultTemplate;
        $viewDir = ROOT_PATH . '/app/templates/frontend/' . $defaultTemplate . '/modules/' . $this->moduleBaseName . '/';
        $pathView = $viewDir . $view->getControllerName() . '/' . $view->getActionName();
        $view->setVar('_templateDir', ROOT_PATH . '/app/templates/frontend/' . $defaultTemplate);
        if (realpath($pathView . '.volt')) {
            $view->setViewsDir($viewDir);
        }
    }
}
