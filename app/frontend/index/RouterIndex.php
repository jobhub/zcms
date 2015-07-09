<?php

use Phalcon\Mvc\Router\Group;

/**
 * Class RouterIndex
 */
class RouterIndex extends Group
{
    public function initialize()
    {
        $this->setPaths([
            'module' => 'index',
            'namespace' => 'ZCMS\Frontend\Index\Controllers'
        ]);

        $this->setPrefix('/');

        $this->add('/logout/', [
            'controller' => 'logout',
            'action' => 'index',
        ]);
    }
}

