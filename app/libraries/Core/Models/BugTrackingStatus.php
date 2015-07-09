<?php
namespace ZCMS\Core\Models;

use ZCMS\Core\ZModel;

/**
 * Class BugTrackingStatus
 *
 * @package ZCMS\Core\Models
 */
class BugTrackingStatus extends ZModel
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
