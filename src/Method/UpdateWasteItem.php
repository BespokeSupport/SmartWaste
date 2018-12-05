<?php

namespace BespokeSupport\SmartWaste\Method;

use BespokeSupport\SmartWaste\Base\BaseMethod;

/**
 * @property mixed cid 
 * @property mixed pid 
 * @property mixed wasteID 
 * @property mixed wasteItem 
 * @property mixed WasteID 
 * @property mixed file 
 */
class UpdateWasteItem extends BaseMethod
{
    public function __construct($cid, $pid, $wasteID, $wasteItem, $WasteID, $file = null)
    {
        $this->cid = $cid;
        $this->pid = $pid;
        $this->wasteID = $wasteID;
        $this->wasteItem = $wasteItem;
        $this->WasteID = $WasteID;
        $this->file = $file;
    }
}