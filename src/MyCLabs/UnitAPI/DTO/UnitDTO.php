<?php

namespace MyCLabs\UnitAPI\DTO;

/**
 * Unit.
 *
 * @author matthieu.napoli
 */
class UnitDTO
{
    const TYPE_STANDARD = 'standard';
    const TYPE_DISCRETE = 'discrete';
    const TYPE_COMPOSED = 'composed';

    /**
     * Identifier.
     * @var string
     */
    public $id;

    /**
     * Label.
     * @var string
     */
    public $label;

    /**
     * Symbol.
     * @var string
     */
    public $symbol;

    /**
     * Type of the unit
     * @var string
     */
    public $type;

    /**
     * ID of the unit system.
     * @var string
     */
    public $unitSystem;
}
