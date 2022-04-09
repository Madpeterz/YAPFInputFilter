<?php

namespace YAPF\InputFilter;

use Exception;

abstract class Convertors extends Checks
{
    /**
     * Takes the current value as string
     * if not null, then runs it in base64 decode and popuplates out the values
     * @return InputFilter The InputFilter object.
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
