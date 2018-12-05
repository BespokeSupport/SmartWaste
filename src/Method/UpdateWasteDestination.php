<?php

namespace BespokeSupport\SmartWaste\Method;

use BespokeSupport\SmartWaste\Base\BaseMethod;

/**
 * @property mixed cid 
 * @property mixed pid 
 * @property mixed destinationID 
 * @property mixed wasteDestination 
 * @property mixed file 
 */
class UpdateWasteDestination extends BaseMethod
{
    public function __construct($cid, $pid, $destinationID, $wasteDestination, $file = null)
    {
        $this->cid = $cid;
        $this->pid = $pid;
        $this->destinationID = $destinationID;
        $this->wasteDestination = $wasteDestination;
        $this->file = $file;
    }
}