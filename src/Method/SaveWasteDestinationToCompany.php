<?php

namespace BespokeSupport\SmartWaste\Method;

use BespokeSupport\SmartWaste\Base\BaseMethod;

/**
 * @property mixed cid 
 * @property mixed wasteDestination 
 * @property mixed file 
 */
class SaveWasteDestinationToCompany extends BaseMethod
{
    public function __construct($cid, $wasteDestination, $file = null)
    {
        $this->cid = $cid;
        $this->wasteDestination = $wasteDestination;
        $this->file = $file;
    }
}