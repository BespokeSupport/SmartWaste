<?php

namespace BespokeSupport\SmartWaste\Method;

use BespokeSupport\SmartWaste\Base\BaseMethod;

/**
 * @property mixed cid 
 * @property mixed pid 
 * @property mixed wasteDestination 
 * @property mixed file 
 */
class SaveWasteDestinationToProject extends BaseMethod
{
    public function __construct($cid, $pid, $wasteDestination, $file = null)
    {
        $this->cid = $cid;
        $this->pid = $pid;
        $this->wasteDestination = $wasteDestination;
        $this->file = $file;
    }
}