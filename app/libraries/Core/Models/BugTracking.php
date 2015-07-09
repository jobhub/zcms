<?php

namespace ZCMS\Core\Models;

use ZCMS\Core\ZModel;

/**
 * Class BugTracking
 *
 * @package ZCMS\Core\Models
 */
class BugTracking extends ZModel
{
    const IMAGE_MAX_FILE_SIZE = 10;
    const IMAGE_BUG_TRACKING_FOLDER = 'images/bug-tracking-images/';
    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $bug_tracking_priority_id;

    /**
     *
     * @var integer
     */
    public $bug_tracking_type_id;

    /**
     *
     * @var integer
     */
    public $role_id;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var string
     */
    public $image;

    /**
     *
     * @var integer
     */
    public $bug_tracking_status_id = 1;


    /**
     * Initialize method for model
     */
    public function initialize()
    {

    }

    /**
     * @return BugTracking
     */
    public static function getBugTrackingNotDone()
    {
        return self::find([
            'conditions' => 'bug_tracking_status_id = 3'
        ]);
    }


}

