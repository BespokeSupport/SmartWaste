<?php

namespace BespokeSupport\SmartWaste\Method;

use BespokeSupport\SmartWaste\Base\BaseMethod;

/**
 * @property mixed cid 
 * @property mixed pid 
 * @property mixed wasteCarrier 
 * @property mixed file 
 */
class SaveWasteCarrierToProject extends BaseMethod
{
    public function __construct($cid, $pid, $wasteCarrier, $file = null)
    {
        $this->cid = $cid;
        $this->pid = $pid;
        $this->wasteCarrier = $wasteCarrier;
        $this->file = $file;
    }
}