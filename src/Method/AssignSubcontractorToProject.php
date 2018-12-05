<?php

namespace BespokeSupport\SmartWaste\Method;

use BespokeSupport\SmartWaste\Base\BaseMethod;

/**
 * @property mixed cid 
 * @property mixed pid 
 * @property mixed subcontractorID 
 */
class AssignSubcontractorToProject extends BaseMethod
{
    public function __construct($cid, $pid, $subcontractorID)
    {
        $this->cid = $cid;
        $this->pid = $pid;
        $this->subcontractorID = $subcontractorID;
    }
}