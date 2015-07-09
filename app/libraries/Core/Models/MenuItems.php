<?php

namespace ZCMS\Core\Models;

use ZCMS\Core\ZModel;

/**
 * Class MenuItem
 *
 * @package ZCMS\Core\Models
 */
class MenuItems extends ZModel
{
    /**
     *
     * @var integer
     */
    public $menu_item_id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $link;

    /**
     *
     * @var string
     */
    public $image;

    /**
     *
     * @var string
     */
    public $thumbnail;

    /**
     *
     * @var integer
     */
    public $parent;

    /**
     *
     * @var integer
     */
    public $published;

    /**
     *
     * @var integer
     */
    public $require_login;

    /**
     *
     * @var string
     */
    public $class;

    /**
     * Initialize method for model
     */
    public function initialize()
    {

    }
} 