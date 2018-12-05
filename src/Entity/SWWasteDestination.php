<?php

namespace BespokeSupport\SmartWaste\Entity;

/**
 * Class SWWasteDestination
 * @package BespokeSupport\SmartWaste\Entity
 */
class SWWasteDestination
{
    /**
     * @var int|null
     */
    public $destinationID;
    /**
     * @var int|null
     */
    public $parentCarrierID;
    /**
     * @var string
     */
    public $destinationName = '';
    /**
     * @var string
     */
    public $address1 = '';
    /**
     * @var string
     */
    public $address2 = '';
    /**
     * @var string
     */
    public $county = '';
    /**
     * @var string
     */
    public $town = '';
    /**
     * @var string
     */
    public $postcode = '';
    /**
     * @var string
     */
    public $wasteTransferNoteStorage = '';
    /**
     * licenceIssueDate
     * licenceExpiryDate
     * licenceNumber
     * @var array
     */
    public $licences = [];

    /**
     * @param string $reference
     * @param \DateTimeInterface|string|null $issued
     */
    public function addLicence(string $reference, $issued = null)
    {
        $issued = $issued ?? new \DateTime();

        if (!$issued instanceof \DateTimeInterface) {
            $issued = new \DateTime($issued);
        }

        $date = $issued->format('d/M/Y');

        $this->licences[] = [
            'licenceNumber' => $reference,
            'licenceIssueDate' => $date,
            'licenceExpiryDate' => '1/1/2099',
        ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $data = [
            'destinationID' => $this->destinationID,
            'parentCarrierID' => $this->parentCarrierID,
            'destinationName' => $this->destinationName,
            'address1' => $this->address1,
            'address2' => $this->address2,
            'town' => $this->town,
            'county' => $this->county,
            'postcode' => $this->postcode,
            'wasteTransferNoteStorage' => $this->wasteTransferNoteStorage,
            'licenses' => $this->licences,
        ];

        return json_encode($data, JSON_UNESCAPED_SLASHES);
    }
}
