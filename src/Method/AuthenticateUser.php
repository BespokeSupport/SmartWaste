<?php

namespace BespokeSupport\SmartWaste\Method;

use BespokeSupport\SmartWaste\Base\BaseMethod;

/**
 * @property mixed username 
 */
class AuthenticateUser extends BaseMethod
{
    public function __construct($username)
    {
        $this->username = $username;
    }
}