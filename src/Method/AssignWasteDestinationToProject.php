<?php

namespace BespokeSupport\SmartWaste\Method;

use BespokeSupport\SmartWaste\Base\BaseMethod;

/**
 * @property mixed cid 
 * @property mixed pid 
 * @property mixed destinationID 
 */
class AssignWasteDestinationToProject extends BaseMethod
{
    public function __construct($cid, $pid, $destinationID)
    {
        $this->cid = $cid;
        $this->pid = $pid;
        $this->destinationID = $destinationID;
    }
}