<?php

namespace ZCMS\Core\Models;

use ZCMS\Core\ZModel;

/**
 * Class CoreMailTemplates
 *
 * @package ZCMS\Core\Models
 */
class CoreMailTemplates extends ZModel
{

    /**
     *
     * @var integer
     */
    public $email_template_id;

    /**
     *
     * @var string
     */
    public $template_code;

    /**
     *
     * @var string
     */
    public $module;

    /**
     *
     * @var string
     */
    public $title;

    /**
     *
     * @var string
     */
    public $subject;

    /**
     *
     * @var string
     */
    public $params;

    /**
     *
     * @var string
     */
    public $body;

    /**
     *
     * @var string
     */
    public $thumb;

    /**
     *
     * @var integer
     */
    public $is_core;

    /**
     *
     * @var string
     */
    public $default_body;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var integer
     */
    public $published;

    /**
     * Initialize method for model
     */
    public function initialize()
    {

    }

}
