<?php

namespace BespokeSupport\SmartWaste;

class SmartWasteRoutes
{
    public const URL_API = 'http://api.smartwaste.co.uk/v1/';

    public static $uri = [
        'authenticate' => 'authenticate/:clientKey',
        'authenticateUser' => 'users/:username',
        'getCompanies' => '{cid}/companies',
        'getDefaultCompanies' => 'companies',
        'assignSubcontractorToProject' => '{cid}/projects/{pid}/subcontractors/{subcontractorID}',
        'assignWasteCarrierToProject' => '{cid}/projects/{pid}/waste-carriers/{carrierID}',
        'assignWasteDestinationToProject' => '{cid}/projects/{pid}/waste-destinations/{destinationID}',
        'getSubcontractorsForProject' => '{cid}/projects/{pid}/subcontractors',
        'getWasteCarriersForProject' => '{cid}/projects/{pid}/waste-carriers',
        'getWasteDestinationsForProject' => '{cid}/projects/{pid}/waste-destinations',
        'saveSubcontractorToCompany' => '{cid}/subcontractors',
        'saveSubcontractorToProject' => '{cid}/projects/{pid}/subcontractors',
        'saveWasteCarrierToCompany' => '{cid}/waste-carriers',
        'saveWasteCarrierToProject' => '{cid}/projects/{pid}/waste-carriers',
        'saveWasteDestinationToCompany' => '{cid}/waste-destinations',
        'saveWasteDestinationToProject' => '{cid}/projects/{pid}/waste-destinations',
        'updateSubcontractor' => '{cid}/projects/{pid}/subcontractors/{subcontractorID}',
        'updateWasteCarrier' => '{cid}/projects/{pid}/waste-carriers/{carrierID}',
        'updateWasteDestination' => '{cid}/projects/{pid}/waste-destinations/{destinationID}',
        'getLabels' => '{cid}/projects/{pid}/labels',
        'getProject' => '{cid}/projects/{pid}',
        'getProjects' => '{cid}/projects',
        'getProjectPhases' => '{cid}/projects/{pid}/project-phases',
        'getSkipsizes' => '{cid}/projects/{pid}/skip-sizes',
        'getTransportOptions' => '{cid}/projects/{pid}/transport-options',
        'getWasteItem' => '{cid}/projects/{pid}/waste-items/{wasteID}',
        'getWasteItems' => '{cid}/projects/{pid}/waste-items',
        'getWasteManagementLocations' => '{cid}/projects/{pid}/waste-management-locations',
        'getWasteManagementRoutes' => '{cid}/projects/{pid}/waste-management-routes',
        'getWasteProductTypes' => '{cid}/projects/{pid}/waste-product-types',
        'getWorkpackages' => '{cid}/projects/{pid}/work-packages',
        'saveWasteItem' => '{cid}/projects/{pid}/waste-items',
        'updateWasteItem' => '{cid}/projects/{pid}/waste-items/{wasteID}',
    ];

    public static $methods = [
        'authenticate' => 'get',
        'authenticateUser' => 'get',
        'getCompanies' => 'get',
        'getDefaultCompanies' => 'get',
        'assignSubcontractorToProject' => 'post',
        'assignWasteCarrierToProject' => 'post',
        'assignWasteDestinationToProject' => 'post',
        'getSubcontractorsForProject' => 'get',
        'getWasteCarriersForProject' => 'get',
        'getWasteDestinationsForProject' => 'get',
        'saveSubcontractorToCompany' => 'post',
        'saveSubcontractorToProject' => 'post',
        'saveWasteCarrierToCompany' => 'post',
        'saveWasteCarrierToProject' => 'post',
        'saveWasteDestinationToCompany' => 'post',
        'saveWasteDestinationToProject' => 'post',
        'updateSubcontractor' => 'put',
        'updateWasteCarrier' => 'put',
        'updateWasteDestination' => 'put',
        'getLabels' => 'get',
        'getProject' => 'get',
        'getProjects' => 'get',
        'getProjectPhases' => 'get',
        'getSkipsizes' => 'get',
        'getTransportOptions' => 'get',
        'getWasteItem' => 'get',
        'getWasteItems' => 'get',
        'getWasteManagementLocations' => 'get',
        'getWasteManagementRoutes' => 'get',
        'getWasteProductTypes' => 'get',
        'getWorkpackages' => 'get',
        'saveWasteItem' => 'post',
        'updateWasteItem' => 'put',
    ];

    public static $groups = [
        'Authentication' => [
            'authenticate',
            'authenticateUser',
        ],
        'Companies' => [
            'getCompanies',
            'getDefaultCompanies',
        ],
        'Contractors' => [
            'assignSubcontractorToProject',
            'assignWasteCarrierToProject',
            'assignWasteDestinationToProject',
            'getSubcontractorsForProject',
            'getWasteCarriersForProject',
            'getWasteDestinationsForProject',
            'saveSubcontractorToCompany',
            'saveSubcontractorToProject',
            'saveWasteCarrierToCompany',
            'saveWasteCarrierToProject',
            'saveWasteDestinationToCompany',
            'saveWasteDestinationToProject',
            'updateSubcontractor',
            'updateWasteCarrier',
            'updateWasteDestination',
        ],
        'Labels' => [
            'getLabels',
        ],
        'Projects' => [
            'getProject',
            'getProjects',
        ],
        'Waste' => [
            'getProjectPhases',
            'getSkipsizes',
            'getTransportOptions',
            'getWasteItem',
            'getWasteItems',
            'getWasteManagementLocations',
            'getWasteManagementRoutes',
            'getWasteProductTypes',
            'getWorkpackages',
            'saveWasteItem',
            'updateWasteItem',
        ],
    ];

    /**
     * @param $obj
     * @return string
     */
    public static function classToShort($obj): string
    {
        try {
            $reflection = new \ReflectionClass($obj);

            $method = lcfirst($reflection->getShortName());

            $uri = SmartWasteRoutes::$uri[$method] ?? null;

            if (!$uri) {
                throw new \RuntimeException("Unknown method '$method'");
            }

            return $method;
            // @codeCoverageIgnoreStart
        } catch (\ReflectionException $e) {
            return '';
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param $obj
     * @return string
     */
    public static function toUrlRelative($obj): string
    {
        $class = self::classToShort($obj);

        $uri = SmartWasteRoutes::$uri[$class] ?? null;

        preg_match_all('#(:\w+)|(\{\w+\})#', $uri, $vars);

        $data = [];
        if (count($vars)) {
            foreach ($vars[0] as $var) {
                $key = preg_replace('#[\:\{\}]#', '', $var);

                $val = $obj->$key ?? null;

                $data[$var] = $val;
            }
        }

        $uri = str_replace(array_keys($data), array_values($data), $uri);

        return $uri;
    }
}
