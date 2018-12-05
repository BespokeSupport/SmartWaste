<?php

namespace BespokeSupport\SmartWaste\Method;

use BespokeSupport\SmartWaste\Base\BaseMethod;

/**
 * @property mixed clientKey 
 */
class Authenticate extends BaseMethod
{
    public function __construct($clientKey)
    {
        $this->clientKey = $clientKey;
    }
}