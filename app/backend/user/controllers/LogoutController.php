<?php

namespace ZCMS\Backend\User\Controllers;

use ZCMS\Core\ZAdminController;

/**
 * Class LogoutController
 *
 * @package ZCMS\Backend\User\Controllers
 */
class LogoutController extends ZAdminController
{
    /**
     * @return \Phalcon\Http\ResponseInterface
     */
    public function indexAction()
    {
        unset($_SESSION);
        $this->session->destroy();
        return $this->response->redirect('/admin/user/login/');
    }
}