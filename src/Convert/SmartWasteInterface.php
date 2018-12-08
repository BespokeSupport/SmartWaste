<?php

namespace BespokeSupport\SmartWaste\Convert;

interface SmartWasteInterface
{
    public function toSmartWasteId(): ?int;
    public function toSmartWasteObj();
}
