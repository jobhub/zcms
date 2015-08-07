<?php

namespace ZCMS\Core\Models;

use ZCMS\Core\ZModel;
use ZCMS\Core\Models\Behavior\NestedSet;

/**
 * Class Categories
 *
 * @package ZCMS\Core\Models
 * @method saveNode
 */
class Categories extends ZModel
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $alias;

    /**
     * Init default value
     */
    public function beforeValidationOnCreate()
    {
        $this->title = strip_tags($this->title);
        if (!$this->alias) {
            $this->alias = generateAlias($this->title);
        }
    }

    /**
     * Init default value
     */
    public function beforeValidationOnUpdate()
    {
        $this->beforeValidationOnCreate();
    }

    public function initialize()
    {
        $this->addBehavior(new NestedSet(array(
            'hasManyRoots' => true,
            'primaryKey' => 'category_id',
            'leftAttribute' => 'lft',
            'rightAttribute' => 'rgt',
            'levelAttribute' => 'level',
            'rootAttribute' => 'root'
        )));
    }

    /**
     * Get all roots
     *
     * @return Categories[]
     */
    public static function getRoots()
    {
        return self::find('lft = 1');
    }

    /**
     * Get tree
     *
     * @param $root_id
     * @return Categories[]
     */
    public static function getTree($root_id)
    {
        return Categories::find(array('root=:root:', 'order' => 'lft', 'bind' => array('root' => $root_id)));
    }

}