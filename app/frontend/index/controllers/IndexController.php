<?php

namespace ZCMS\Frontend\Index\Controllers;

use ZCMS\Core\ZEmail;
use ZCMS\Core\ZFrontController;

/**
 * Class IndexController
 *
 * @package ZCMS\Frontend\Index\Controllers
 */
class IndexController extends ZFrontController
{
    public function indexAction()
    {
//        $ok = ZEmail::getInstance()
//            ->addTo('kimthangatm@gmail.com', 'Kim Tan')
//            ->setSubject('Register account successfully!')
//            ->setTemplate('index','register_with_form_success', [
//                'username' => 'kimtan',
//                'password' => 'YOUR PASSWORD'
//            ])->send();
//        echo '<pre>'; var_dump($ok);echo '</pre>'; die();
    }
}