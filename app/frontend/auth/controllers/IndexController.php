<?php

namespace ZCMS\Frontend\Auth\Controllers;

use ZCMS\Core\Social\ZFacebook;
use ZCMS\Core\ZFrontController;

/**
 * Class IndexController
 *
 * @package ZCMS\Frontend\Auth\Controllers
 */
class IndexController extends ZFrontController
{
    public function indexAction()
    {
        $fb = ZFacebook::getInstance();
        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['email'];
        $loginUrl = $helper->getLoginUrl(BASE_URI . '/facebook/login-callback/', $permissions);

        echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
    }
}