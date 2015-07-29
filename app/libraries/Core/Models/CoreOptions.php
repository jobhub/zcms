<?php

namespace ZCMS\Core\Models;

use Phalcon\Mvc\Model;

/**
 * Class CoreOptions
 *
 * @package ZCMS\Core\Models
 */
class CoreOptions extends Model
{
    /**
     * @var int
     */
    public $option_id;

    /**
     * @var string
     */
    public $option_scope;

    /**
     * @var string
     */
    public $option_name;

    /**
     * @var string
     */
    public $option_value;

    /**
     * If value equal 1 then option autoload to CACHE
     *
     * @var int Value in [0,1]
     */
    public $autoload;
}