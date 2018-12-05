<?php

namespace BespokeSupport\SmartWaste\Parse;

class ParseAssignWasteDestinationToProject
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