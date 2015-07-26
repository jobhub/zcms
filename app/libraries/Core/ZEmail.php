<?php

namespace ZCMS\Core\ZEmail;

use Swift_Mailer;
use Phalcon\Mvc\View;
use Swift_SmtpTransport;
use Swift_SendmailTransport;
use ZCMS\Core\ZFactory;

require_once ROOT_PATH . '/app/libraries/SwiftMailer/lib/swift_required.php';

class ZEmail
{
    /**
     * @var ZEmail $instance an object ZEmail
     */
    public static $instance;

    /**
     * @var string Module base name
     */
    public $module;

    /**
     * @var string
     */
    public $template;

    /**
     * @var View
     */
    public $view;

    /**
     * @var Swift_Mailer
     */
    public $mailer;

    /**
     * @var mixed
     */
    private $config;

    /**
     * Get Security Instance
     *
     * @param string $module
     * @param string $template
     * @param array $data
     * @param array $config
     * @return ZEmail
     */
    public static function getInstance($module, $template, $data, $config = null)
    {
        if (!is_object(self::$instance)) {
            self::$instance = new ZEmail($module, $template, $data, $config);
        }
        return self::$instance;
    }

    /**
     * Instance construct
     *
     * @param string $module
     * @param string $template
     * @param array $data
     * @param array $config
     */
    public function __construct($module, $template, $data = [], $config)
    {
        $this->_initConfig($config);
        $this->_initView($data);
        $this->module = $module;
        $this->template = $template;
    }

    /**
     * Init config
     *
     * @param $config
     */
    private function _initConfig($config)
    {
        if (!$config) {
            $this->config = ZFactory::getConfig();
        }
        if ($config['mailType'] == 'smtp') {
            $transport = Swift_SmtpTransport::newInstance($config['smtpHost'], $config['smtpPort'], $config['smtpAuth'])
                ->setUsername($config['smtpUser'])
                ->setPassword($config['smtpPass']);
            $this->mailer = Swift_Mailer::newInstance($transport);
        } else {
            $transport = Swift_SendmailTransport::newInstance($config['sendMail']);
            $this->mailer = Swift_Mailer::newInstance($transport);
        }
    }

    /**
     * Send Email
     */
    public function send()
    {
        $this->view->start();
        $overrideFolder = ROOT_PATH . '/app/templates/frontend/' . $this->config->frontendTemplate->defaultTemplate . '/email/';
        $overrideFile = $overrideFolder . $this->module . DS . $this->template . '.volt';
        if (file_exists($overrideFile)) {
            $this->view->setViewsDir($overrideFolder);
            $this->view->render($this->module, $this->template)->getContent();
        } else {
            $this->view->setViewsDir(ROOT_PATH . '/app/frontend/' . $this->module . DS);
            $this->view->render('email', $this->template)->getContent();
        }
        $this->view->finish();
        $content = $this->view->getContent();
        $html = $this->beforeWidget();
    }

    /**
     * Init view to bind data to email template
     *
     * @param $data
     */
    private function _initView($data)
    {
        $this->view = new View();
        $this->view->setVar('data', $data);
    }

    /**
     * Set template
     *
     * @param string $template
     * @return $this
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * Set module name
     *
     * @param string $module
     * @return $this
     */
    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }
}