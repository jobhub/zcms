<?php

namespace ZCMS\Frontend\Auth\Controllers;

use ZCMS\Core\Models\CoreOptions;
use ZCMS\Core\Social\ZGoogle;
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
        echo '<pre>'; var_dump(CoreOptions::getOptions('blog_prefix','zcms'));echo '</pre>'; die();
        $google = ZGoogle::getInstance();
        if($google->isReady){
            $me = $google->getMe();

            echo '<pre>'; var_dump($me->getName()->familyName);echo '</pre>'; die();
        }else{
            $code = $this->request->get('code','string','');
            if($code){
                $google->checkRedirectCode($code);
                $me = $google->getMe();
                echo '<pre>'; var_dump($me->getName());echo '</pre>'; die();
            }else{
                $this->response->redirect('/');
                return;
            }
        }
    }
}