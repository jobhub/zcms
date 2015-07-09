<?php
namespace ZCMS\Core\Models;

use Phalcon\Mvc\Model;

/**
 * Class BugTrackingPriority
 *
 * @package ZCMS\Core\Models
 */
class BugTrackingPriority extends Model
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
