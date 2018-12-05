<?php

namespace BespokeSupport\SmartWasteTests\Entity;

trait TraitTestEntityBase
{
    /**
     * @param $ent
     * @return string
     */
    private function entityToString($ent): string
    {
        return (string) $ent;
    }

    /**
     * @param string $entStr
     * @return mixed
     */
    private function entityStringToEntity(string $entStr)
    {
        return json_decode($entStr);
    }
}