<?php

namespace BespokeSupport\SmartWaste;

use BespokeSupport\SmartWaste\Method\SaveWasteCarrierToCompany;
use BespokeSupport\SmartWaste\Method\SaveWasteDestinationToCompany;
use GuzzleHttp\Client;

class SmartWasteCreate
{
    /**
     * @param SmartWasteCredentials $credentials
     * @param SaveWasteCarrierToCompany $carrierToCompany
     * @param Client|null $client
     * @return int|null
     */
    public static function carrier(SmartWasteCredentials $credentials, SaveWasteCarrierToCompany $carrierToCompany, Client $client = null)
    {
        $res = SmartWaste::call($credentials, $carrierToCompany, [
            'wasteCarrier' => $carrierToCompany->wasteCarrier,
            'file' => $carrierToCompany->file,
        ], $client);

        return $res->carrierID ?? null;
    }

    /**
     * @param SmartWasteCredentials $credentials
     * @param SaveWasteDestinationToCompany $destinationToCompany
     * @param Client|null $client
     * @return int|null
     */
    public static function destination(SmartWasteCredentials $credentials, SaveWasteDestinationToCompany $destinationToCompany, Client $client = null)
    {
        $res = SmartWaste::call($credentials, $destinationToCompany, [
            'wasteDestination' => $destinationToCompany->wasteDestination,
            'file' => $destinationToCompany->file,
        ], $client);

        return $res->destinationID ?? null;
    }
}