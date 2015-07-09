<?php

namespace ZCMS\Frontend\Email\Controllers;

use ZCMS\Core\Email\ZEmail;
use ZCMS\Core\Models\CoreEmail;
use ZCMS\Core\ZFrontController;

/**
 * Class IndexController
 * @package ZCMS\Frontend\Email\Controllers
 */
class IndexController extends ZFrontController
{
    public function sendEmailAction()
    {
        $emailID = $this->request->get('emailID');
        $emailID = (int)$emailID;

        if ($emailID) {
            $mailer = new ZEmail();
            $mailer->IsHTML();

            $emailID = (int)$emailID;
            /**
             * @var \ZCMS\Core\Models\CoreEmail $mailNeedToSend
             */
            $mailNeedToSend = CoreEmail::findFirst('id = ' . $emailID);
            if ($mailNeedToSend) {
                $mailer->Subject = $mailNeedToSend->subject;
                $to = explode(':', $mailNeedToSend->email_to);
                $bcc = explode(':', $mailNeedToSend->email_bcc);
                $cc = explode(':', $mailNeedToSend->email_cc);
                $filesPath = explode(':', $mailNeedToSend->attachment_files);
                $mailer->SMTPDebug = 4;
                //Add TO
                foreach ($to as $email) {
                    $mailer->AddAddress($email);
                }

                //Add BCC
                foreach ($bcc as $email) {
                    $mailer->AddBCC($email);
                }

                //Add BCC
                foreach ($cc as $email) {
                    $mailer->AddCC($email);
                }
                if (count($filesPath)) {
                    foreach ($filesPath as $filePath) {
                        $mailer->AddAttachment($filePath);
                    }
                }

                $mailer->setBody($mailNeedToSend->body);
                if ($mailer->sendEmail()) {
                    $mailNeedToSend->send_status = true;
                    $mailNeedToSend->save();
                    die('1');
                } else {
                    echo '<pre><br />' . __METHOD__;
                    var_dump($mailer->ErrorInfo);
                    echo '</pre>';
                    die('');
                }
            }

        }
        $this->view->disable();
    }
} 