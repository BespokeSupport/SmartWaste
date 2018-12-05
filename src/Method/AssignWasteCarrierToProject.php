<?php

namespace BespokeSupport\SmartWaste\Method;

use BespokeSupport\SmartWaste\Base\BaseMethod;

/**
 * @property mixed cid 
 * @property mixed pid 
 * @property mixed carrierID 
 */
class AssignWasteCarrierToProject extends BaseMethod
{
    public function __construct($cid, $pid, $carrierID)
    {
        $this->cid = $cid;
        $this->pid = $pid;
        $this->carrierID = $carrierID;
    }
}