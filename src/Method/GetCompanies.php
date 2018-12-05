<?php

namespace BespokeSupport\SmartWaste\Method;

use BespokeSupport\SmartWaste\Base\BaseMethod;

/**
 * @property mixed cid 
 */
class GetCompanies extends BaseMethod
{
    public function __construct($cid)
    {
        $this->cid = $cid;
    }
}