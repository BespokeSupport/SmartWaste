<?php

namespace BespokeSupport\SmartWaste;

use BespokeSupport\SmartWaste\Base\BaseMethod;
use BespokeSupport\SmartWaste\Entity\SWCompany;
use BespokeSupport\SmartWaste\Entity\SWLabel;
use BespokeSupport\SmartWaste\Entity\SWProject;
use BespokeSupport\SmartWaste\Entity\SWSubcontractor;
use BespokeSupport\SmartWaste\Entity\SWWasteCarrier;
use BespokeSupport\SmartWaste\Entity\SWWasteDestination;
use BespokeSupport\SmartWaste\Entity\SWWasteItem;
use BespokeSupport\SmartWaste\Method\Authenticate;
use BespokeSupport\SmartWaste\Method\AuthenticateUser;
use BespokeSupport\SmartWaste\Method\GetCompanies;
use BespokeSupport\SmartWaste\Method\GetDefaultCompanies;
use BespokeSupport\SmartWaste\Method\AssignSubcontractorToProject;
use BespokeSupport\SmartWaste\Method\AssignWasteCarrierToProject;
use BespokeSupport\SmartWaste\Method\AssignWasteDestinationToProject;
use BespokeSupport\SmartWaste\Method\GetSubcontractorsForProject;
use BespokeSupport\SmartWaste\Method\GetWasteCarriersForProject;
use BespokeSupport\SmartWaste\Method\GetWasteDestinationsForProject;
use BespokeSupport\SmartWaste\Method\SaveSubcontractorToCompany;
use BespokeSupport\SmartWaste\Method\SaveSubcontractorToProject;
use BespokeSupport\SmartWaste\Method\SaveWasteCarrierToCompany;
use BespokeSupport\SmartWaste\Method\SaveWasteCarrierToProject;
use BespokeSupport\SmartWaste\Method\SaveWasteDestinationToCompany;
use BespokeSupport\SmartWaste\Method\SaveWasteDestinationToProject;
use BespokeSupport\SmartWaste\Method\UpdateSubcontractor;
use BespokeSupport\SmartWaste\Method\UpdateWasteCarrier;
use BespokeSupport\SmartWaste\Method\UpdateWasteDestination;
use BespokeSupport\SmartWaste\Method\GetLabels;
use BespokeSupport\SmartWaste\Method\GetProject;
use BespokeSupport\SmartWaste\Method\GetProjects;
use BespokeSupport\SmartWaste\Method\GetProjectPhases;
use BespokeSupport\SmartWaste\Method\GetSkipsizes;
use BespokeSupport\SmartWaste\Method\GetTransportOptions;
use BespokeSupport\SmartWaste\Method\GetWasteItem;
use BespokeSupport\SmartWaste\Method\GetWasteItems;
use BespokeSupport\SmartWaste\Method\GetWasteManagementLocations;
use BespokeSupport\SmartWaste\Method\GetWasteManagementRoutes;
use BespokeSupport\SmartWaste\Method\GetWasteProductTypes;
use BespokeSupport\SmartWaste\Method\GetWorkpackages;
use BespokeSupport\SmartWaste\Method\SaveWasteItem;
use BespokeSupport\SmartWaste\Method\UpdateWasteItem;

use GuzzleHttp\Client;

/**
 * @method static string|null authenticate(SmartWasteCredentials $credentials, Authenticate $obj, Client $client = null)
 * @method static bool authenticateUser(SmartWasteCredentials $credentials, AuthenticateUser $obj, Client $client = null)
 * @method static SWCompany[] getCompanies(SmartWasteCredentials $credentials, GetCompanies $obj, Client $client = null)
 * @method static SWCompany[] getDefaultCompanies(SmartWasteCredentials $credentials, GetDefaultCompanies $obj, Client $client = null)
 * @method static bool assignSubcontractorToProject(SmartWasteCredentials $credentials, AssignSubcontractorToProject $obj, Client $client = null)
 * @method static bool assignWasteCarrierToProject(SmartWasteCredentials $credentials, AssignWasteCarrierToProject $obj, Client $client = null)
 * @method static bool assignWasteDestinationToProject(SmartWasteCredentials $credentials, AssignWasteDestinationToProject $obj, Client $client = null)
 * @method static SWSubcontractor[] getSubcontractorsForProject(SmartWasteCredentials $credentials, GetSubcontractorsForProject $obj, Client $client = null)
 * @method static SWWasteCarrier[] getWasteCarriersForProject(SmartWasteCredentials $credentials, GetWasteCarriersForProject $obj, Client $client = null)
 * @method static SWWasteDestination[] getWasteDestinationsForProject(SmartWasteCredentials $credentials, GetWasteDestinationsForProject $obj, Client $client = null)
 * @method static int|null saveSubcontractorToCompany(SmartWasteCredentials $credentials, SaveSubcontractorToCompany $obj, Client $client = null)
 * @method static int|null saveSubcontractorToProject(SmartWasteCredentials $credentials, SaveSubcontractorToProject $obj, Client $client = null)
 * @method static int|null saveWasteCarrierToCompany(SmartWasteCredentials $credentials, SaveWasteCarrierToCompany $obj, Client $client = null)
 * @method static int|null saveWasteCarrierToProject(SmartWasteCredentials $credentials, SaveWasteCarrierToProject $obj, Client $client = null)
 * @method static int|null saveWasteDestinationToCompany(SmartWasteCredentials $credentials, SaveWasteDestinationToCompany $obj, Client $client = null)
 * @method static int|null saveWasteDestinationToProject(SmartWasteCredentials $credentials, SaveWasteDestinationToProject $obj, Client $client = null)
 * @method static bool updateSubcontractor(SmartWasteCredentials $credentials, UpdateSubcontractor $obj, Client $client = null)
 * @method static bool updateWasteCarrier(SmartWasteCredentials $credentials, UpdateWasteCarrier $obj, Client $client = null)
 * @method static bool updateWasteDestination(SmartWasteCredentials $credentials, UpdateWasteDestination $obj, Client $client = null)
 * @method static SWLabel[] getLabels(SmartWasteCredentials $credentials, GetLabels $obj, Client $client = null)
 * @method static SWProject getProject(SmartWasteCredentials $credentials, GetProject $obj, Client $client = null)
 * @method static SWProject[] getProjects(SmartWasteCredentials $credentials, GetProjects $obj, Client $client = null)
 * @method static array getProjectPhases(SmartWasteCredentials $credentials, GetProjectPhases $obj, Client $client = null)
 * @method static array getSkipsizes(SmartWasteCredentials $credentials, GetSkipsizes $obj, Client $client = null)
 * @method static array getTransportOptions(SmartWasteCredentials $credentials, GetTransportOptions $obj, Client $client = null)
 * @method static SWWasteItem getWasteItem(SmartWasteCredentials $credentials, GetWasteItem $obj, Client $client = null)
 * @method static SWWasteItem[] getWasteItems(SmartWasteCredentials $credentials, GetWasteItems $obj, Client $client = null)
 * @method static array getWasteManagementLocations(SmartWasteCredentials $credentials, GetWasteManagementLocations $obj, Client $client = null)
 * @method static array getWasteManagementRoutes(SmartWasteCredentials $credentials, GetWasteManagementRoutes $obj, Client $client = null)
 * @method static array getWasteProductTypes(SmartWasteCredentials $credentials, GetWasteProductTypes $obj, Client $client = null)
 * @method static array getWorkpackages(SmartWasteCredentials $credentials, GetWorkpackages $obj, Client $client = null)
 * @method static int saveWasteItem(SmartWasteCredentials $credentials, SaveWasteItem $obj, Client $client = null)
 * @method static bool updateWasteItem(SmartWasteCredentials $credentials, UpdateWasteItem $obj, Client $client = null)
 */
class SmartWasteApi
{
    public static function __callStatic($method, $args)
    {
        /**
         * @var $credentials SmartWasteCredentials
         * @var $obj BaseMethod
         * @var $client Client|null
         */
        $credentials = $args[0] ?? null;
        $obj = $args[1] ?? null;
        $client = $args[2] ?? null;

        if (!$credentials || !$credentials instanceof SmartWasteCredentials) {
            throw new \LogicException('Credentials not provided');
        }

        if (!$obj || !$obj instanceof BaseMethod) {
            throw new \LogicException('API Method object not provided');
        }

        if ($client && !$client instanceof Client) {
            throw new \LogicException('Client should be instance of GuzzleClient');
        }

        $params = SmartWaste::params($obj);

        $client = $client ?? SmartWaste::client($credentials);

        $res = SmartWaste::call($credentials, $obj, $params, $client);

        return $res;
    }
}