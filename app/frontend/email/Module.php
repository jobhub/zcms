<?php

namespace ZCMS\Frontend\Email;

use ZCMS\Core\ZFrontModule;

/**
 * Module send email background
 *
 * @package ZCMS\Frontend\Email
 */
class Module extends ZFrontModule
{
    /**
     * Define module name
     *
     * @var string
     */
    protected $module_name = 'email';

    /**
     * Module Constructor
     */
    public function __construct()
    {
        parent::__construct($this->module_name);
    }
}
