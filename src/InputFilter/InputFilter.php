<?php

namespace YAPF\InputFilter;

use PhpParser\Node\Expr\Cast\Double;
use YAPF\InputFilter\Rules;

class InputFilter extends Rules
{
    public function asHumanReadable(?string $defaultNull = null): ?string
    {
        $output = $this->valueAsString;
        if ($this->valueAsHumanReadable != null) {
            $output =  $this->valueAsHumanReadable;
        }
        return $output ?? $defaultNull;
    }

    public function asString(?string $defaultNull = null): ?string
    {
        return $this->valueAsString ?? $defaultNull;
    }

    public function asFloat(?float $defaultNull = null): ?float
    {
        return $this->valueAsFloat ?? $defaultNull;
    }

    public function asInt(?int $defaultNull = null): ?int
    {
        return $this->valueAsInt ?? $defaultNull;
    }

    public function asBool(?bool $defaultNull = null): bool
    {
        return $this->valueAsBool ?? $defaultNull;
    }

    /**
     * asArray
     * returns the result as an array or null
     * @return ?mixed[]
     */
    public function asArray(?array $defaultNull = null): ?array
    {
        return $this->valueAsArray ?? $defaultNull;
    }
}
