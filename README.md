#SmartWaste API

[SmartWaste](http://www.smartwaste.co.uk/smarter/) is a recognised way to aggregate environmental data (including waste transactions).
This PHP library provides a way to read and write data using the API.

## Use Cases
* BRE Customer extracting data to their internal system
* BRE Customer inputting data
* Waste Contractor (Carrier)
* Broker uploading on behalf of many contractors

## Current SmartWaste API Version

1.3.0

## Obtain and Create API Access token
Note: This is not your username and password. 

Please obtain these credentials by speaking to BRE.
```
$credentials = SmartWaste::token('user', 'publicKey', 'privateKey');
```

##Methods available
Methods can be called from SmartWasteAPI::METHOD or SmartWaste::api($credentials, METHOD, $params)

    assignSubcontractorToProject
    assignWasteCarrierToProject
    assignWasteDestinationToProject
    authenticate
    authenticateUser
    getCompanies
    getDefaultCompanies
    getLabels
    getProject
    getProjectPhases
    getProjects
    getSkipsizes
    getSubcontractorsForProject
    getTransportOptions
    getWasteCarriersForProject
    getWasteDestinationsForProject
    getWasteItem
    getWasteItems
    getWasteManagementLocations
    getWasteManagementRoutes
    getWasteProductTypes
    getWorkpackages
    saveSubcontractorToCompany
    saveSubcontractorToProject
    saveWasteCarrierToCompany
    saveWasteCarrierToProject
    saveWasteDestinationToCompany
    saveWasteDestinationToProject
    saveWasteItem
    updateSubcontractor
    updateWasteCarrier
    updateWasteDestination
    updateWasteItem


## Lookup Endpoints

| API | For |
| :---: | :---:|
| getSkipsizes | Skip Sizes |
| getWasteProductTypes | Waste Product Types (EWCs) |
| getProjectPhases | Project Phases |
| getTransportOptions | Vehicle Type e.g. HGV |
| getWasteManagementRoutes | End Destination - Recycle, Landfill, Energy |
| getWasteManagementLocations | On/Off site |    

# Examples

## Create Carrier

```
$ent = new SmartWasteWasteCarrier();

$ent->carrierName = 'ABC Skips';
$ent->postcode = 'AA11 1AA';
$ent->address1 = '1 Main Street';
$ent->addLicence('AA1234AA', '2020-01-01');

$obj = new SaveWasteCarrierToCompany(12345, $ent); // 12345 is your Company ID

$res = SmartWaste::call($credentials, $obj);

// $res = wasteCarrierID (int)
```

## Create Destination (Depot)
```
$ent = new SmartWasteWasteDestination();

$ent->parentCarrierID = 54321; // ID created during above call

$ent->destinationName = 'ABC Skips';
$ent->postcode = 'AA11 1AA';
$ent->address1 = '1 Main Street';
$ent->addLicence('AA1234AA', '2020-01-01');

$obj = new SaveWasteDestinationToCompany(12345, $ent); // 12345 is your Company ID

$res = SmartWaste::call($credentials, $obj);

// $res = wasteDestinationID (int)
```


## Save Waste Item
```
$ent = new SmartWasteWasteItem();

// convert your waste item data

$obj = new SaveWasteItem(12345, 12345, $ent);

$res = SmartWaste::call($credentials, $obj);

// $res = wasteItemID (int)
```