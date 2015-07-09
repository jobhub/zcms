<?php

use Phalcon\Mvc\Router\Group;

/**
 * Class RouterEmail
 */
class RouterEmail extends Group
{
    public function initialize()
    {
        $this->setPaths([
            'module' => 'email',
            'namespace' => 'ZCMS\Frontend\Email\Controllers'
        ]);

        $this->setPrefix('/email');

        $this->add('/', [
            'controller' => 'index',
            'action' => 'index',
        ]);

        $this->add('/send-email/', [
            'controller' => 'index',
            'action' => 'sendEmail',
        ]);
    }
}

