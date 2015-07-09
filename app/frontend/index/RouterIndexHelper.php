<?php

use ZCMS\Core\ZRouter;

/**
 * Class Router Helper for Index Module
 */
class RouterIndexHelper extends ZRouter
{
    /**
     * @var int
     */
    public $limit = 10;

    /**
     * @var array
     */
    public $routerType = [
        [
            'type' => 'link',
            'menu_name' => 'm_index_router_home_page',
            'menu_link' => '/' //Home Page
        ]
    ];
}