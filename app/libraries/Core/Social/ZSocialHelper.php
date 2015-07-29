<?php

namespace ZCMS\Core\Social;

use ZCMS\Core\Models\CoreOptions;
use ZCMS\Core\Models\UserRoles;
use ZCMS\Core\Models\Users;
use ZCMS\Core\ZEmail;

/**
 * Class ZSocialHelper
 *
 * @package ZCMS\Core\Social
 */
class ZSocialHelper
{
    /**
     * @var array
     */
    public $userInfo;

    /**
     * @var string
     */
    public $socialName;

    /**
     * @var array
     */
    public static $socialSupport = [
        'facebook',
        'google',
        'twitter'
    ];

    /**
     * @var Users
     */
    public $user;

    /**
     * Init social helper
     *
     * @param array $userInfo
     * @param string $socialName Value = facebook, google, twitter
     */
    public function __construct(array $userInfo, $socialName = '')
    {
        $this->userInfo = $userInfo;
        $this->socialName = strtolower($socialName);
    }

    public function process()
    {
        if ($this->userInfo['first_name'] && $this->userInfo['last_name'] && $this->userInfo['email'] && in_array($this->socialName, self::$socialSupport)) {
            $autoLoginIfAccountExists = CoreOptions::getOptions('social_automatic_' . $this->socialName, 'zcms', 1);
            $sendEmailActivateAccount = CoreOptions::getOptions('social_automatic_' . $this->socialName, 'zcms', 1);
            $this->user = Users::findFirst([
                'conditions' => 'email = ?0',
                'bind' => [$this->userInfo['email']]
            ]);
            $propertyName = 'is_active_' . $this->socialName;
            if ($this->user) {
                if ($this->user->$propertyName == 1) {
                    $this->user->loginCurrentUSer();
                    return true;
                }
                if ($autoLoginIfAccountExists) {
                    $this->_updateLoginWithSocial();
                    $this->user->loginCurrentUSer();
                    return true;
                } else {
                    $ok = $this->_generateActiveAccountWithSocial();
                    if ($ok) {
                        return '_ZT_Please Activate Account from Email';
                    } else {
                        return '_ZT_System is busy, please try again later!';
                    }
                }
            } else {
                $this->user = new Users();
                $this->user->first_name = $this->userInfo['first_name'];
                $this->user->last_name = $this->userInfo['last_name'];
                $this->user->email = $this->userInfo['email'];

                if ($sendEmailActivateAccount) {
                    $ok = $this->_generateActiveAccountWithSocial();
                    if ($ok) {
                        return '_ZT_Please Activate Account from Email';
                    } else {
                        return '_ZT_System is busy, please try again later!';
                    }
                } else {
                    $this->user->is_active = 1;
                    if ($this->user->save()) {
                        $this->user->loginCurrentUSer();
                    } else {
                        return '_ZT_System is busy, please try again later!';
                    }
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Update user in send email activate login with social
     *
     * @return bool
     */
    private function _generateActiveAccountWithSocial()
    {
        $defaultCustomerRoleID = UserRoles::getDefaultCustomerRoleID();
        if($defaultCustomerRoleID){
            $this->user->active_account_token = randomString(100) . time() . '_' . base64_encode($this->socialName);
            $this->user->active_account_type = $this->socialName;
            $this->user->is_active = 0;
            $this->user->role_id = $defaultCustomerRoleID;
            $data = [
                'active_account_token' => $this->user->active_account_token,
                'email' => $this->user->email,
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
            ];
            $email = ZEmail::getInstance();
            if ($this->user->save()) {
                $email->setSubject('_ZT_Activate Account')
                    ->addTo($this->user->email, $this->user->first_name . $this->user->last_name)
                    ->setTemplate('auth', 'register_with_' . $this->socialName, $data)->send();
                return true;
            }
        }
        return false;
    }

    /**
     * Update login with social
     *
     * @return bool
     */
    private function _updateLoginWithSocial()
    {
        if ($this->socialName == 'facebook') {
            $this->user->is_active_facebook = 1;
        } elseif ($this->socialName == 'google') {
            $this->user->is_active_google = 1;
        }
        if (!$this->user->active_account_at) {
            $this->user->active_account_at = date('Y-m-d H:i:s');
        }
        return $this->user->save();
    }

    public static function processActivateWithToken($token)
    {
        if (strlen($token) > 100) {
            /**
             * @var Users $user
             */
            $user = Users::findFirst([
                'conditions' => 'active_account_token = ?0',
                'bind' => [$token]
            ]);
            if ($user) {
                if ($user->active_account_type != '') {
                    if ($user->active_account_type == 'facebook') {
                        $user->is_active_facebook = 1;
                    } elseif ($user->active_account_type == 'google') {
                        $user->is_active_google = 1;
                    }
                    if (!$user->active_account_at) {
                        $user->active_account_at = date('Y-m-d H:i:s');
                    }
                    $user->active_account_type = null;
                    $user->active_account_token = null;
                    $user->is_active = 1;
                    if ($user->save()) {
                        $user->loginCurrentUSer();
                        return true;
                    }
                }
            }
        }
        return false;
    }
}