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

    public function asChunks(int $size=1, ?array $defaultNull = null): ?array
    {
        if($this->valueAsString == null)
        {
            return $defaultNull;
        }
        if($size < 1)
        {
            $size = 1;
        }
        return str_split($this->valueAsString, $size);
    }

    public function asList(string $separator=" ", ?int $limit=null, ?array $defaultNull = null): ?array
    {
        if($this->valueAsString == null)
        {
            return $defaultNull;
        }
        if($limit == null)
        {
            return explode($separator, $this->valueAsString);
        }
        return explode($separator, $this->valueAsString, $limit);
    }

    public function asCsv(?array $defaultNull = null): ?array
    {
        return $this->asList(",",null,$defaultNull);
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
