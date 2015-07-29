<?php

namespace ZCMS\Core\Social;

/**
 * Class ZSocialHelper
 *
 * @package ZCMS\Core\Social
 */
class ZSocialHelper
{
    public $userInfo;

    /**
     * Init social helper
     *
     * @param array $userInfo
     */
    public function __construct(array $userInfo)
    {
       $this->userInfo = $userInfo;
    }

    public function process(){
        if($this->userInfo['first_name'] && $this->userInfo['last_name'] && $this->userInfo['email']){

        }
        return false;
    }
}