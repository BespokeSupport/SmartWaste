<?php

namespace BespokeSupport\SmartWaste\Method;

use BespokeSupport\SmartWaste\Base\BaseMethod;

/**
 * @property mixed cid 
 * @property mixed subcontractor 
 */
class SaveSubcontractorToCompany extends BaseMethod
{
    public function __construct($cid, $subcontractor)
    {
        $this->cid = $cid;
        $this->subcontractor = $subcontractor;
    }
}