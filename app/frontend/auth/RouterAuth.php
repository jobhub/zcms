<?php

use Phalcon\Mvc\Router\Group;

/**
 * Class RouterAuth
 */
class RouterAuth extends Group
{
    public function initialize()
    {
        $this->setPaths([
            'module' => 'auth',
            'namespace' => 'ZCMS\Frontend\Auth\Controllers'
        ]);

        $this->add('/facebook/login-callback(/)?', [
            'controller' => 'facebook',
            'action' => 'login',
        ]);
    }
}

