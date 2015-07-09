<?php

namespace ZCMS\Core\Models;

use Phalcon\Mvc\Model;

/**
 * Class CoreEmail
 *
 * @package ZCMS\Core\Models
 */
class CoreEmail extends Model
{
    const MAX_SEND_COUNT = 3;

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $subject;

    /**
     *
     * @var string
     */
    public $email_to;

    /**
     *
     * @var string
     */
    public $email_bcc;

    /**
     *
     * @var string
     */
    public $email_cc;

    /**
     *
     * @var string
     */
    public $body;

    /**
     *
     * @var string
     */
    public $create_at;

    /**
     *
     * @var string
     */
    public $send_status;

    /**
     *
     * @var integer
     */
    public $send_count;

    /**
     *
     * @var string
     */
    public $attachment_files;

    /**
     *
     * @var string
     */
    public $exec_log;

    public function initialize()
    {

    }
}
