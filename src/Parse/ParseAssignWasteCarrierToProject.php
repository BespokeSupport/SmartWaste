<?php

namespace BespokeSupport\SmartWaste\Parse;

class ParseAssignWasteCarrierToProject
{
    public function parse($json)
    {
        if (!$json || !count($json)) {
            return false;
        }

        $success = $json[0]->success ?? false;

        return $success;
    }
}