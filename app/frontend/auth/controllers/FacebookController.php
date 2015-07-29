<?php

namespace ZCMS\Frontend\Auth\Controllers;

use ZCMS\Core\Social\ZFacebook;
use ZCMS\Core\ZFrontController;

/**
 * Class IndexController
 *
 * @package ZCMS\Frontend\Auth\FacebookController
 */
class FacebookController extends ZFrontController
{
    /**
     * Login callback
     */
    public function loginAction()
    {
        $fb = ZFacebook::getInstance();

        $accessToken = null;

        $helper = $fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();
        } catch (\Exception $e) {
            $this->flashSession->notice('_ZT_Cannot access');
            $this->response->redirect('/login/');
            return;
        }

        if (isset($accessToken)) {
            // Logged in!
            $this->session->set('_SOCIAL_FACEBOOK_ACCESS_TOKEN', (string)$accessToken);
            $fb->setDefaultAccessToken((string)$accessToken);
            try {
                $response = $fb->get('/me?fields=email,name');
                //$response = $fb->get('/me');
                $userNode = $response->getGraphUser();
                echo '<pre>'; var_dump($userNode); echo '</pre>'; die();
            } catch(\Exception $e) {
                echo '<pre>'; var_dump($e); echo '</pre>'; die();
                $this->flashSession->notice('_ZT_Facebook server is busy, please try again later!');
            }
        }
    }
}