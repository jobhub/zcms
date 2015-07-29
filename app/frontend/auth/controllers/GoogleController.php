<?php

namespace ZCMS\Frontend\Auth\Controllers;

use ZCMS\Core\Social\ZGoogle;
use ZCMS\Core\Social\ZSocialHelper;
use ZCMS\Core\ZFrontController;

/**
 * Class IndexController
 *
 * @package ZCMS\Frontend\Auth\GoogleController.php
 */
class GoogleController extends ZFrontController
{
    /**
     * Login callback
     */
    public function loginAction()
    {
        $google = ZGoogle::getInstance();
        if ($google->isReady) {
            $this->_process($google);
        } else {
            $code = $this->request->get('code', 'string', '');
            if ($code) {
                $google->checkRedirectCode($code);
                $this->_process($google);
            }
        }
        $this->response->redirect('/');
    }

    /**
     * Process login with Google
     *
     * @param ZGoogle $google
     */
    private function _process($google)
    {
        $userInfo = $google->getUserInfoToCreateAccount();
        if ($userInfo) {
            $message = (new ZSocialHelper($userInfo, 'google'))->process();
            if (gettype($message) == 'string' && strlen($message)) {
                $this->flashSession->notice($message);
            }
        }
    }
}