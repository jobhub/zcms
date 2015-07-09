<?php

namespace ZCMS\Core\Models;

use Phalcon\Mvc\Model;

/**
 * Class BugTrackingType
 *
 * @package ZCMS\Core\Models
 */
class BugTrackingType extends Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var integer
     */
    public $ordering;

    /**
     * Initialize method for model
     */
    public function initialize()
    {

    }

}
