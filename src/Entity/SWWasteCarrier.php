<?php

namespace BespokeSupport\SmartWaste\Entity;

/**
 * Class SWWasteCarrier
 * @package BespokeSupport\SmartWaste\Entity
 */
class SWWasteCarrier
{
    /**
     * @var int|null
     */
    public $carrierID;
    /**
     * @var string
     */
    public $carrierName = '';
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
     * @param \DateTimeInterface|string|null $expires
     */
    public function addLicence(string $reference, $expires = null)
    {
        $expires = $expires ?? new \DateTime();

        if (!$expires instanceof \DateTimeInterface) {
            $expires = new \DateTime($expires);
        }

        $date = $expires->format('d/M/Y');

        try {
            $issued = $expires->sub(new \DateInterval('-3Y'))->format('d/M/Y');
        } catch (\Exception $e) {
            $issued = null;
        }

        $this->licences[] = [
            'licenceNumber' => $reference,
            'licenceExpiryDate' => $date,
            'licenceIssueDate' => $issued,
        ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $data = [
            'carrierID' => $this->carrierID,
            'carrierName' => $this->carrierName,
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
