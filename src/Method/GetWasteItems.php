<?php

namespace BespokeSupport\SmartWaste\Method;

use BespokeSupport\SmartWaste\Base\BaseMethod;

/**
 * @property mixed cid 
 * @property mixed pid 
 */
class GetWasteItems extends BaseMethod
{
    public function __construct($cid, $pid)
    {
        $this->cid = $cid;
        $this->pid = $pid;
    }
}