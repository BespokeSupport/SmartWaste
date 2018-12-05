<?php

namespace BespokeSupport\SmartWaste\Method;

use BespokeSupport\SmartWaste\Base\BaseMethod;

/**
 * @property mixed cid 
 * @property mixed pid 
 * @property mixed wasteItem 
 * @property mixed file 
 */
class SaveWasteItem extends BaseMethod
{
    public function __construct($cid, $pid, $wasteItem, $file = null)
    {
        $this->cid = $cid;
        $this->pid = $pid;
        $this->wasteItem = $wasteItem;
        $this->file = $file;
    }
}