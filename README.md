# Client API for Units

## Value class

A `Value` object represents a numeric value expressed in a unit, optionally with an uncertainty.

```php
// This value represents 15 meters
$value1 = new Value(15, 'm');

// This value represents 200 kilometers with an uncertainty of 10% (+/- 20 kilometers)
$value2 = new Value(200, 'km', 10);

echo $value2->getNumericValue(); // 200
echo $value2->getUnit();         // km
echo $value2->getUncertainty();  // 10

echo $value2; // 200 km ± 10 %
```

Values can be easily serialized to string:

``php
$value1 = new Value(100, 'm', 5);

$str = $value->serialize();

$value2 = Value::unserialize($str);

var_dump($value1 == $value2); // true
```

## Conversion service

Methods:

- `convert(Value $value, string $targetUnit)`: converts a Value into another unit, returns a new `Value`

## Unit service

Methods:

- `getUnits()`: returns all units available (`UnitDTO[]`)
- `getUnit($id)`: returns a unit by its id (`UnitDTO`)
- `getUnitSystems()`: returns all unit systems (`UnitSystemDTO[]`)
- `getPhysicalQuantities()`: returns all physical quantities (`PhysicalQuantityDTO[]`)

## Webservice implementations

The services described above are interfaces.

The implementation provided uses the webservice provided by the MyCLabs Units application.

This implementation has the following specific behavior:

- throws `MyCLabs\UnitAPI\WebService\WebServiceException` if there is an error while calling the webservice
