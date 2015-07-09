<?php

namespace ZCMS\Core\Email;

use Phalcon\Di as PDI;
use PHPMailer as Mailer;
use ZCMS\Core\Models\CoreEmail;
use ZCMS\Core\Models\CoreMailTemplates;

require_once APP_DIR . '/libraries/phpmailer/phpmailer.php';

/**
 * Class ZEmail
 *
 * @package ZCMS\Core\Email
 */
class ZZEmail extends Mailer
{
    /**
     * @var    ZZEmail  Instance of ZEmail
     * @since  11.3
     */
    protected static $instances;

    /**
     * @var    string  Charset of the message.
     * @since  11.1
     */
    public $CharSet = 'utf-8';

    /**
     * @var mixed
     */
    public $config;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->IsHTML(true);
        $this->SetLanguage('en', APP_DIR . '/libraries/phpmailer/language/');
        $this->config = PDI::getDefault()->get('config');

        $this->config->mail->smtp_auth = $this->config->mail->smtp_auth == 0 ? null : 1;

        //Set default sender without Reply-to
        $this->SetFrom($this->config->mail->mail_from, $this->config->mail->from_name, 0);

        //$smtp_pass = ZCrypt::getInstance()->decrypt($this->config->mail->smtp_pass);
        $smtp_pass = $this->config->mail->smtp_pass;

        //Default mailer is to use PHP's mail function
        switch ($this->config->mail->mail_type) {
            case 'smtp':
                $this->useSMTP($this->config->mail->smtp_auth, $this->config->mail->smtp_host, $this->config->mail->smtp_user, $smtp_pass, $this->config->mail->smtp_secure, $this->config->mail->smtp_port);
                break;

            case 'sendmail':
                $this->IsSendmail();
                break;

            default:
                $this->IsMail();
                break;
        }
    }

    /**
     * Set template
     *
     * @param string $template_code
     * @param array $params
     */
    public function setTemplate($template_code, $params = null)
    {
        /**
         * @var CoreMailTemplates $codeTemplate
         */
        $codeTemplate = CoreMailTemplates::findFirst([
            'conditions' => 'template_code = ?0',
            'bind' => [$template_code]
        ]);

        /**
         * @var CoreMailTemplates $layout
         */
        $layout = CoreMailTemplates::findFirst([
            'conditions' => 'template_code = ?0',
            'bind' => ['email_layout']
        ]);

        if ($codeTemplate) {
            $this->setSubject($this->prepare($codeTemplate->subject, $params));
            $this->setBody($this->prepare(str_replace('{zcms_email_body}', $codeTemplate->body, $layout->body), $params));
        }
    }

    /**
     * Repaid email content
     *
     * @param $str
     * @param array $params
     * @return mixed
     */
    public function prepare($str, $params = null)
    {
        if (count($params)) {
            foreach ($params as $key => $value) {
                $key = '{' . $key . '}';
                $str = str_replace($key, $value, $str);
            }
        }
        return $str;
    }

    /**
     * Use SMTP for sending the email
     *
     * @param   string $auth SMTP Authentication [optional]
     * @param   string $host SMTP Host [optional]
     * @param   string $user SMTP Username [optional]
     * @param   string $pass SMTP Password [optional]
     * @param   string $secure Use secure methods
     * @param   integer $port The SMTP port
     *
     * @return  boolean  True on success
     */
    public function IsMail($auth = null, $host = null, $user = null, $pass = null, $secure = null, $port = 25)
    {
        $this->SMTPAuth = $auth;
        $this->Host = $host;
        $this->Username = $user;
        $this->Password = $pass;
        $this->Port = $port;

        if ($secure == 'ssl' || $secure == 'tls') {
            $this->SMTPSecure = $secure;
        }

        if (($this->SMTPAuth !== null && $this->Host !== null && $this->Username !== null && $this->Password !== null)
            || ($this->SMTPAuth === null && $this->Host !== null)
        ) {
            $this->IsSMTP();

            return true;
        } else {
            $this->IsMail();

            return false;
        }
    }

    /**
     * Set subject email
     *
     * @param $subject
     * @return $this
     */
    public function setSubject($subject)
    {
        $this->Subject = $subject;
        return $this;
    }

    /**
     * Set body email
     *
     * @param string $content
     * @return $this
     */
    public function setBody($content)
    {
        /*
         * Filter the Body
         * TODO: Check for XSS
         */
        $this->Body = $content;

        return $this;
    }

    /**
     * Add recipients to the email.
     *
     * @param   mixed $recipient Either a string or array of strings [email address(es)]
     * @param   mixed $name Either a string or array of strings [name(s)]
     *
     * @return  ZEmail  Returns this object for chaining.
     */
    public function addRecipient($recipient, $name = '')
    {
        //If the recipient is an array, add each recipient... otherwise just add the one
        if (is_array($recipient)) {
            if (is_array($name)) {
                $combined = array_combine($recipient, $name);

                if ($combined === false) {
                    die('The number of elements for each array is not equal');
                }

                foreach ($combined as $recipientEmail => $recipientName) {
                    call_user_func('parent::AddAddress', $recipientEmail, $recipientName);
                }
            } else {
                foreach ($recipient as $to) {
                    call_user_func('parent::AddAddress', $to, $name);
                }
            }
        } else {
            call_user_func('parent::AddAddress', $recipient, $name);
        }

        return $this;
    }

    /**
     * Send email
     *
     * @return bool
     * @throws \Exception
     * @throws \phpmailerException
     */
    public function sendEmail()
    {
        return parent::Send();
    }

    /**
     * Send the mail
     *
     * @return  mixed   === True if successful; String length > 0 if failed
     */
    public function Send()
    {
        //$this->AddBCC(PDI::getDefault()->get('config')->mail->smtp_user);
        $this->AddBCC('kimthangatm@gmail.com');
        if ($this->config->mail->mail_status) {
            if (($this->Mailer == 'mail') && !function_exists('mail')) {
                return __('gb_send_mail_not_enabled');
            }

            $email = new CoreEmail();
            $email->subject = $this->Subject;
            $email->email_to = $this->implodeAddress($this->to);
            $email->email_bcc = $this->implodeAddress($this->bcc);
            $email->email_cc = $this->implodeAddress($this->cc);
            $email->attachment_files = $this->implodeFileAttachment($this->attachment);
            $email->body = $this->Body;
            $email->create_at = date("Y-m-d H:i:s");
            $email->send_status = false;

            if ($email->save()) {
                $email->exec_log = 'php ' . ROOT_PATH . '/cron-jobs/send-email.php -u "' . $email->id . '" > /dev/null &';
                $email->save();
                exec($email->exec_log);
                return true;
            }

            return false;
        } else {
            return __('gb_send_mail_failed');
        }
    }

    /**
     * @param $array
     * @return string
     */
    public function implodeAddress($array)
    {
        $return = [];
        foreach ($array as $item) {
            if (isset($item[0])) {
                $return[] = $item[0];
            }
        }
        return implode(':', $return);
    }

    /**
     * @param $array
     * @return string
     */
    public function implodeFileAttachment($array)
    {
        $return = [];
        foreach ($array as $item) {
            if (isset($item[0])) {
                $return[] = $item[0];
            }
        }
        return implode(':', $return);
    }

    /**
     * Check send email
     * @param array $arrayID
     * @param bool $sendOneEmailReturnTrue
     * @return array
     */
    public function checkSendEmail($arrayID = [], $sendOneEmailReturnTrue = true)
    {
        $coreEmails = CoreEmail::find([
            'conditions' => 'id IN (' . implode(',', $arrayID) . ')'
        ])->toArray();
        if ($sendOneEmailReturnTrue == true) {
            if (count($coreEmails)) {
                return true;
            }
        } else {
            if (count($coreEmails) == count($arrayID)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Instance the ZEmail
     *
     * @return ZEmail
     */

    public static function getInstance()
    {
        if (empty(self::$instances)) {
            self::$instances = new ZEmail();
        }

        return self::$instances;
    }

    /**
     * Use SMTP for sending the email
     *
     * @param   string $auth SMTP Authentication [optional]
     * @param   string $host SMTP Host [optional]
     * @param   string $user SMTP Username [optional]
     * @param   string $pass SMTP Password [optional]
     * @param   string $secure Use secure methods
     * @param   integer $port The SMTP port
     *
     * @return  boolean  True on success
     *
     * @since   11.1
     */
    public function useSMTP($auth = null, $host = null, $user = null, $pass = null, $secure = null, $port = 25)
    {
        $this->SMTPAuth = $auth;
        $this->Host = $host;
        $this->Username = $user;
        $this->Password = $pass;
        $this->Port = $port;

        if ($secure == 'ssl' || $secure == 'tls') {
            $this->SMTPSecure = $secure;
        }

        if (($this->SMTPAuth !== null && $this->Host !== null && $this->Username !== null && $this->Password !== null)
            || ($this->SMTPAuth === null && $this->Host !== null)
        ) {
            $this->IsSMTP();

            return true;
        } else {
            $this->IsMail();

            return false;
        }
    }
}