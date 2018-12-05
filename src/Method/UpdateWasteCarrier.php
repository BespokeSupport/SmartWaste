<?php

namespace BespokeSupport\SmartWaste\Method;

use BespokeSupport\SmartWaste\Base\BaseMethod;

/**
 * @property mixed cid 
 * @property mixed pid 
 * @property mixed carrierID 
 * @property mixed wasteCarrier 
 * @property mixed file 
 */
class UpdateWasteCarrier extends BaseMethod
{
    public function __construct($cid, $pid, $carrierID, $wasteCarrier, $file = null)
    {
        $this->cid = $cid;
        $this->pid = $pid;
        $this->carrierID = $carrierID;
        $this->wasteCarrier = $wasteCarrier;
        $this->file = $file;
    }
}