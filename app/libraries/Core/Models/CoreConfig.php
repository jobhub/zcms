<?php

namespace ZCMS\Core\Models;

use ZCMS\Core\ZModel;

/**
 * Class CoreConfigs
 *
 * @package ZCMS\Core\Models
 */
class CoreConfigs extends ZModel
{
    /**
     *
     * @var integer
     */
    public $config_id;

    /**
     *
     * @var string
     */
    public $scope;

    /**
     *
     * @var string
     */
    public $key;

    /**
     *
     * @var string
     */
    public $value;

    /**
     *
     * @var integer
     */
    public $is_crypt_value;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {

    }
}