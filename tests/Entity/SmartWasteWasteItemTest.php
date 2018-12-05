<?php

namespace BespokeSupport\SmartWasteTests\Entity;

use BespokeSupport\SmartWaste\Entity\SWWasteItem;
use BespokeSupport\SmartWasteTests\Convert\ConvertEntity;
use PHPUnit\Framework\TestCase;

class SmartWasteWasteItemTest extends TestCase
{
    use TraitTestEntityBase;

    public function test__toString()
    {
        $ent = new SWWasteItem();

        $str = $this->entityToString($ent);

        $this->assertEquals('{"wasteID":null,"dateEntered":null,"projectPhase":{"projectPhaseID":null},"wasteCarrier":{"carrierID":null},"wasteDestination":{"destinationID":null},"wasteManagementRoute":{"wasteManagementRouteID":null},"wasteManagementLocation":{"wasteManagementLocationID":null},"skipSize":{"skipSizeID":null},"wasteTransferNote":null,"numberOfContainers":1,"containerSegregated":false,"overallTonnage":0,"links":[],"labels":[],"wasteProducts":[]}', $str);

        $obj = $this->entityStringToEntity($str);

        $labels = $obj->labels ?? [];
        $this->assertCount(0, $labels);
        $links = $obj->links ?? [];
        $this->assertCount(0, $links);
    }

    public function test__addLink()
    {
        $ent = new SWWasteItem();

        $link = 'http://www.google.co.uk';

        $ent->addLink($link);

        $str = $this->entityToString($ent);

        $obj = $this->entityStringToEntity($str);

        $links = $obj->links ?? [];

        $this->assertCount(1, $links);
    }

    public function test__addLabel()
    {
        $ent = new SWWasteItem();

        $label = 'region';

        $ent->addLabel($label);

        $str = $this->entityToString($ent);

        $obj = $this->entityStringToEntity($str);

        $labels = $obj->labels ?? [];

        $this->assertCount(1, $labels);
    }

    public function test__setDate()
    {
        $ent = new SWWasteItem();

        $date = new \DateTime();

        $ent->setDate($date);

        $str = $this->entityToString($ent);

        $obj = $this->entityStringToEntity($str);

        $val = $obj->dateEntered ?? null;

        $this->assertNotNull($val);

        $this->assertEquals($date->format('Y-m-d'), \DateTime::createFromFormat('d/m/Y', $val)->format('Y-m-d'));
    }

    public function test__addProduct()
    {
        $ent = new SWWasteItem();

        $ent->wasteProducts[] = ['percentage' => 80];

        $str = $this->entityToString($ent);

        $obj = $this->entityStringToEntity($str);

        $arr = $obj->wasteProducts ?? [];

        $this->assertCount(1, $arr);

        $void = $obj->voidPercentage ?? null;

        $this->assertEquals(20, $void);
    }

    public function test__setSkipId()
    {
        $orig = new ConvertEntity();

        $ent = new SWWasteItem();

        $ent->setSkipId($orig);

        $this->assertEquals(ConvertEntity::ID, $ent->skipSize);
    }

    public function test__setProjectPhaseId()
    {
        $orig = new ConvertEntity();

        $ent = new SWWasteItem();

        $ent->setProjectPhaseId($orig);

        $this->assertEquals(ConvertEntity::ID, $ent->projectPhase);
    }

    public function test__setWasteCarrierId()
    {
        $orig = new ConvertEntity();

        $ent = new SWWasteItem();

        $ent->setWasteCarrierId($orig);

        $this->assertEquals(ConvertEntity::ID, $ent->wasteCarrier);
    }

    public function test__setWasteDestinationId()
    {
        $orig = new ConvertEntity();

        $ent = new SWWasteItem();

        $ent->setWasteDestinationId($orig);

        $this->assertEquals(ConvertEntity::ID, $ent->wasteDestination);
    }

    public function test__addSinglePercentage()
    {
        $ent = new SWWasteItem();

        $ent->setSingleWeightPercent(ConvertEntity::ID, 90);

        $this->assertCount(1, $ent->wasteProducts);
    }

    public function test__addSingleTonnage()
    {
        $ent = new SWWasteItem();

        $ent->setSingleWeightTonnage(ConvertEntity::ID, 1);

        $this->assertCount(1, $ent->wasteProducts);
    }

    public function test__addTonnage()
    {
        $ent = new SWWasteItem();

        $ent->addBreakdownTonnage(ConvertEntity::ID, 1);

        $this->assertCount(1, $ent->wasteProducts);
    }

    public function test__addPercent()
    {
        $ent = new SWWasteItem();

        $ent->addBreakdownPercent(ConvertEntity::ID, 90);

        $this->assertCount(1, $ent->wasteProducts);
    }
}
