# Client API for the Units application

[![Build Status](https://travis-ci.org/myclabs/Units-API.png?branch=master)](https://travis-ci.org/myclabs/Units-API)

## Unit service

Methods:

- `getUnits()`: returns all units available (`UnitDTO[]`)
- `getUnit($id)`: returns a unit by its id (`UnitDTO`)
- `getUnitSystems()`: returns all unit systems (`UnitSystemDTO[]`)
- `getPhysicalQuantities()`: returns all physical quantities (`PhysicalQuantityDTO[]`)

## Operation service

Methods:

- `getConversionFactor(string $unit1, string $unit2)`: returns the conversion factor between unit1 and unit2

## Webservice implementations

The services described above are interfaces.

The implementation provided uses the webservice provided by the MyCLabs Units application.

This implementation has the following specific behavior:

- throws `MyCLabs\UnitAPI\WebService\WebServiceException` if there is an error while calling the webservice
