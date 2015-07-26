<?php

namespace ZCMS\Frontend\Index\Controllers;

use ZCMS\Core\Models\Users;
use ZCMS\Core\ZFrontController;

/**
 * Class ForgotPasswordController
 * @package ZCMS\Frontend\Index\Controllers
 */
class ForgotPasswordController extends ZFrontController
{
    public function indexAction()
    {
        if ($this->isLogin()) {
            return $this->response->redirect('/');
        }
        if ($this->request->isPost()) {
            $email = $this->request->getPost('email', null, '');
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                /**
                 * @var Users $user
                 */
                $user = Users::findFirst([
                    'conditions' => 'email = ?0',
                    'bind' => [$email]
                ]);
                if ($user) {
                    $user->reset_password_token = $this->security->getToken(60) . '.' . base64_encode($email);
                    $user->reset_password_token_at = date('Y-m-d H:i:s');
                    $user->save();
//                    $mailer = ZEmail::getInstance();
//                    $mailer->setSubject(__('Reset your password'));
//                    $body = __('Hello');
//                    $body .= '<br /><br />To reset password account please click on the following link' . ':';
//                    $body .= '<br /><a href="' . BASE_URI . '/tao-mat-khau-moi/?token=' . $user->reset_password_token . '">' . BASE_URI . '/tao-mat-khau-moi/?token=' . $user->reset_password_token . '</a>';
//                    //$body .= '<br />' . __('We wish you a lot of success with your') . '!';
//                    $body .= '<br />';
//                    $mailer->setBody($body);
//                    $mailer->addRecipient($user->email);
//                    $mailer->sendEmail();
                    $this->flashSession->success(__('Please check your email to retrieve password'));
                    $this->response->redirect('/dang-nhap/');
                    return true;
                } else {
                    $this->flashSession->error('Email not found');
                }
            } else {
                $this->flashSession->error('Email invalid');
                return false;
            }
        }
        return false;
    }
}