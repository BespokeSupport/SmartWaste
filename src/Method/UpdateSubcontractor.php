<?php

namespace BespokeSupport\SmartWaste\Method;

use BespokeSupport\SmartWaste\Base\BaseMethod;

/**
 * @property mixed cid 
 * @property mixed pid 
 * @property mixed subcontractorID 
 * @property mixed subcontractor 
 */
class UpdateSubcontractor extends BaseMethod
{
    public function __construct($cid, $pid, $subcontractorID, $subcontractor)
    {
        $this->cid = $cid;
        $this->pid = $pid;
        $this->subcontractorID = $subcontractorID;
        $this->subcontractor = $subcontractor;
    }
}