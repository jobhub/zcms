<?php

namespace ZCMS\Backend\Media\Controllers;

use ZCMS\Core\Utilities\MediaUpload;
use ZCMS\Core\ZAdminController;

/**
 * Class ManagerController
 *
 * @package ZCMS\Backend\Media\Controllers
 */
class ManagerController extends ZAdminController
{
    public function indexAction()
    {

    }

    public function newAction()
    {
        $this->view->setVar('max_file_upload', (int)ini_get("upload_max_filesize"));
        if ($this->request->isAjax()) {
            if ($files = $this->request->getUploadedFiles()) {
                $msg = (new MediaUpload($files[0]))->msg;
                die(json_encode($msg));
            }
        }
    }

    public function uploadImageAction()
    {

    }
}