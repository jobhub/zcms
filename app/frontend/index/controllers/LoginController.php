<?php

namespace ZCMS\Frontend\Index\Controllers;

use ZCMS\Core\Social\ZFacebook;
use ZCMS\Core\ZFrontController;

/**
 * Class LoginController
 *
 * @package ZCMS\Frontend\Index\Controllers
 */
class LoginController extends ZFrontController
{
    public function indexAction()
    {
        $fb = ZFacebook::getInstance();
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email'];
        $this->view->setVar('loginUrl', $helper->getLoginUrl(BASE_URI . '/facebook/login-callback/', $permissions));
    }
}