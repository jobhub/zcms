<?php

namespace ZCMS\Frontend\Index\Controllers;

use ZCMS\Core\Models\Categories;
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
        /**
         * @var Categories $iphone6
         */
        $iphone6 = Categories::findFirst(4);
        $iphone6->alias = '';
        if($iphone6->saveNode()){
            echo '<pre>'; var_dump('ok');echo '</pre>'; die();
        }else{
            echo '<pre>'; var_dump($iphone6->getMessages());echo '</pre>'; die();
        }
    }
}