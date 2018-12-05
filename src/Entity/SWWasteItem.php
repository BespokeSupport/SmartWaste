<?php

namespace BespokeSupport\SmartWaste\Entity;

use BespokeSupport\SmartWaste\Convert\SmartWasteInterface;

/**
 * Class SWWasteItem
 * @package BespokeSupport\SmartWaste\Entity
 */
class SWWasteItem
{
    /**
     * @var int
     */
    public $wasteID;
    /**
     * @var string
     */
    public $dateEntered;
    /**
     * @var int
     */
    public $numberOfContainers = 1;
    /**
     * @var string
     */
    public $wasteTransferNote;
    /**
     * @var string
     */
    public $containerReference;
    /**
     * @var string
     */
    public $createdByCompanyName;
    /**
     * @var bool
     */
    public $containerSegregated = false;
    /**
     * @var double
     */
    public $overallTonnage;
    /**
     * @var int
     */
    public $voidPercentage;
    /**
     * projectPhaseID
     * @var
     */
    public $projectPhase;
    /**
     * carrierID
     * @var int
     */
    public $wasteCarrier;
    /**
     * destinationID
     * @var int
     */
    public $wasteDestination;
    /**
     * wasteManagementRouteID
     * @var
     */
    public $wasteManagementRoute;
    /**
     * wasteManagementLocationID
     * @var
     */
    public $wasteManagementLocation;
    /**
     * skipSizeID
     * @var
     */
    public $skipSize;
    /**
     * wasteProductID
     * tonnage
     * percentage
     * @var array
     */
    public $wasteProducts = [];
    /**
     * uri
     * @var array
     */
    public $links = [];
    /**
     * @var array
     */
    public $labels = [];

    /**
     * @param SmartWasteInterface $smartWaste
     */
    public function setWasteCarrierId(SmartWasteInterface $smartWaste)
    {
        $this->wasteCarrier = $smartWaste->toSmartWasteId();
    }

    public function setWasteDestinationId(SmartWasteInterface $smartWaste)
    {
        $this->wasteDestination = $smartWaste->toSmartWasteId();
    }

    public function setProjectPhaseId(SmartWasteInterface $smartWaste)
    {
        $this->projectPhase = $smartWaste->toSmartWasteId();
    }

    public function setSkipId(SmartWasteInterface $smartWaste)
    {
        $this->skipSize = $smartWaste->toSmartWasteId();
    }

    /**
     * @param \DateTimeInterface $date
     */
    public function setDate(\DateTimeInterface $date): void
    {
        $this->dateEntered = $date->format('d/m/Y');
    }

    /**
     * @param int $productId
     * @param float $percentage
     */
    public function addBreakdownPercent(int $productId, float $percentage)
    {
        $this->wasteProducts[] = [
            'wasteProductID' => $productId,
            'percentage' => $percentage,
        ];
    }

    /**
     * @param int $productId
     * @param float $tonnage
     */
    public function addBreakdownTonnage(int $productId, float $tonnage)
    {
        $this->wasteProducts[] = [
            'wasteProductID' => $productId,
            'tonnage' => $tonnage,
        ];
    }

    /**
     * @param int $productId
     * @param float $percentage
     */
    public function setSingleWeightPercent(int $productId, float $percentage = 100)
    {
        $this->wasteProducts = [[
            'wasteProductID' => $productId,
            'percentage' => $percentage,
        ]];
    }

    /**
     * @param int $productId
     * @param float $tonnage
     */
    public function setSingleWeightTonnage(int $productId, float $tonnage)
    {
        $this->wasteProducts = [[
            'wasteProductID' => $productId,
            'tonnage' => $tonnage,
            'percentage' => 100,
        ]];
    }

    /**
     * @param string $uri
     */
    public function addLink($uri): void
    {
        $this->links[] = [
            'rel' => 'self',
            'type' => 'GET',
            'uri' => $uri,
        ];
    }

    /**
     * @param int $labelID
     * @param string $labelColour
     */
    public function addLabel($labelID, $labelColour = 'label-orange'): void
    {
        $this->labels[] = [
            'labelID' => $labelID,
            'labelColour' => $labelColour,
        ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $tonnage = $percent = 0;

        foreach ($this->wasteProducts as $product) {
            $tonnage += $product['tonnage'] ?? 0;
            $percent += $product['percentage'] ?? 0;
        }

        $voidPercentage = null;
        if ($percent && $percent != 100) {
            $voidPercentage = 100 - $percent;
        }

        $overallTonnage = $this->overallTonnage ?: $tonnage;

        $data = [
            'wasteID' => $this->wasteID,
            'dateEntered' => $this->dateEntered,
            'projectPhase' => [
                'projectPhaseID' => $this->projectPhase
            ],
            'wasteCarrier' => [
                'carrierID' => $this->wasteCarrier
            ],
            'wasteDestination' => [
                'destinationID' => $this->wasteDestination
            ],
            'wasteManagementRoute' => [
                'wasteManagementRouteID' => $this->wasteManagementRoute
            ],
            'wasteManagementLocation' => [
                'wasteManagementLocationID' => $this->wasteManagementLocation
            ],
            'skipSize' => [
                'skipSizeID' => $this->skipSize,
            ],
            'wasteTransferNote' => $this->wasteTransferNote,
            'numberOfContainers' => $this->numberOfContainers,
            'containerSegregated' => $this->containerSegregated,
            'overallTonnage' => $overallTonnage,
            'links' => $this->links,
            'labels' => $this->labels,
            'wasteProducts' => $this->wasteProducts,
        ];

        if ($voidPercentage !== null) {
            $data['voidPercentage'] = $voidPercentage;
        }

        return json_encode($data, JSON_UNESCAPED_SLASHES);
    }
}
