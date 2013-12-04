<?php

namespace MyCLabs\UnitAPI;

use InvalidArgumentException;

/**
 * Numeric value.
 */
class Value
{
    /**
     * Numeric value.
     * @var float
     */
    private $numericValue;

    /**
     * Expression of the unit in which the numeric value is expressed.
     * @var string
     */
    private $unit;

    /**
     * Relative uncertainty, in percent.
     * @var float|null
     */
    private $uncertainty;

    /**
     * @param float      $numericValue Numeric value.
     * @param string     $unit         Expression of the unit in which the numeric value is expressed.
     * @param float|null $uncertainty  Relative uncertainty, in percent.
     */
    public function __construct($numericValue, $unit, $uncertainty = null)
    {
        $this->numericValue = (float) $numericValue;
        $this->unit = (string) $unit;
        if ($uncertainty !== null) {
            $this->uncertainty = (float) $uncertainty;
        }
    }

    /**
     * @return float Numeric value.
     */
    public function getNumericValue()
    {
        return $this->numericValue;
    }

    /**
     * @return string Expression of the unit in which the numeric value is expressed.
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @return float|null Relative uncertainty, in percent.
     */
    public function getUncertainty()
    {
        return $this->uncertainty;
    }

    /**
     * Export the object to a string representation.
     *
     * @return string
     */
    public function serialize()
    {
        return $this->numericValue . '|' . $this->unit . '|' . $this->uncertainty;
    }

    /**
     * Creates a Value from a string representation
     *
     * @param string $str Must contain a string with this format: "value unit uncertainty"
     *
     * @throws InvalidArgumentException Invalid string
     * @return self
     */
    public static function unserialize($str)
    {
        if (substr_count($str, '|') !== 2) {
            throw new InvalidArgumentException("The string has an invalid format: '$str'");
        }

        list($value, $unit, $uncertainty) = explode('|', $str);

        return new static($value, $unit, $uncertainty);
    }

    /**
     * Cast the object to a string. For debug purposes only.
     *
     * @return string
     */
    public function __toString()
    {
        if ($this->uncertainty === null) {
            return "$this->numericValue $this->unit";
        }

        return "$this->numericValue $this->unit ± $this->uncertainty %";
    }
}
