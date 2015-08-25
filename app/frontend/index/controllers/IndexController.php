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
        $dir = ROOT_PATH . '/public/media/upload/' . date('Y/m/d');
        if(!is_dir($dir)){
            mkdir($dir, 0755,true);
        }
        echo '<pre>'; var_dump($dir);echo '</pre>'; die();
//        $root = Categories::findFirst(1);
//        $iphone6 = new Categories();
//        $iphone6->title = 'Iphone 6';
//        if($iphone6->appendTo($root)){
//
//        }else{
//            echo '<pre>'; var_dump($iphone6->getMessages());echo '</pre>'; die();
//        };
//        $cats = Categories::find(array('root=:root:', 'order' => 'lft', 'bind' => array('root' => 1)));
//        echo '<pre>'; var_dump($cats->toArray());echo '</pre>'; die();
    }
}