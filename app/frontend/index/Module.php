<?php

namespace ZCMS\Frontend\Index;

use ZCMS\Core\ZFrontModule;

/**
 * Class Module
 *
 * @package ZCMS\Frontend\Index
 */
class Module extends ZFrontModule
{
    /**
     * Define module name
     *
     * @var string
     */
    protected $module_name = 'index';

    /**
     * Module Constructor
     */
    public function __construct()
    {
        parent::__construct($this->module_name);
    }
}
