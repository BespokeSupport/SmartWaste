<?php

use BespokeSupport\SmartWaste\Entity\SWWasteDestination;
use PHPUnit\Framework\TestCase;

class SmartWasteWasteDestinationTest extends TestCase
{
    use \BespokeSupport\SmartWasteTests\Entity\TraitTestEntityBase;

    public function test__toString()
    {
        $ent = new SWWasteDestination();

        $str = (string) $ent;

        $this->assertEquals('{"destinationID":null,"parentCarrierID":null,"destinationName":"","address1":"","address2":"","town":"","county":"","postcode":"","wasteTransferNoteStorage":"","licenses":[]}', $str);
    }

    public function test__addLicence()
    {
        $ent = new SWWasteDestination();

        $ref = 111;

        $dateStr = '2018-01-01';
        $dateObj = new DateTime($dateStr);

        $ent->addLicence($ref, $dateObj);

        $str = $this->entityToString($ent);

        $obj = $this->entityStringToEntity($str);

        $arr = $obj->licenses ?? [];

        $this->assertCount(1, $arr);
    }

    public function test__addLicenceString()
    {
        $ent = new SWWasteDestination();

        $ref = 111;

        $dateStr = '2018-01-01';

        $ent->addLicence($ref, $dateStr);

        $str = $this->entityToString($ent);

        $obj = $this->entityStringToEntity($str);

        $arr = $obj->licenses ?? [];

        $this->assertCount(1, $arr);
    }
}
