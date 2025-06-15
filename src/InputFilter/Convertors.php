<?php

namespace YAPF\InputFilter;

use Exception;

/**
 * Class Convertors
 * Provides conversion utilities for input values.
 */
abstract class Convertors extends Checks
{
    /**
     * Decodes the current string value from base64 and updates the value properties.
     */
    public function fromBase64(): InputFilter
    {
        if ($this->valueAsString == null) {
            return $this;
        }
        $value = $this->valueAsString;
        $this->reset();
        $this->convertValue("self", "valueAsString", base64_decode($value));
        return $this;
    }
}
