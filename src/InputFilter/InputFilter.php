<?php

namespace YAPF\InputFilter;

use PhpParser\Node\Expr\Cast\Double;
use YAPF\InputFilter\Rules;

/**
 * Class InputFilter
 * Main entry point for input filtering, conversion, and value extraction.
 */
class InputFilter extends Rules
{
    /**
     * Returns the value as a human-readable string, or the given default if not available.
     * @param string|null $defaultNull
     */
    public function asHumanReadable(?string $defaultNull = null): ?string
    {
        $output = $this->valueAsString;
        if ($this->valueAsHumanReadable != null) {
            $output =  $this->valueAsHumanReadable;
        }
        return $output ?? $defaultNull;
    }

    /**
     * Splits the string value into chunks of the given size.
     * @param int $size
     * @param array|null $defaultNull
     * @return array<int, string>|null
     */
    public function asChunks(int $size = 1, ?array $defaultNull = null): ?array
    {
        if ($this->valueAsString == null) {
            return $defaultNull;
        }
        if ($size < 1) {
            $size = 1;
        }
        return str_split($this->valueAsString, $size);
    }

    /**
     * Splits the string value into an array using the given separator and optional limit.
     * @param string $separator
     * @param int|null $limit
     * @param array|null $defaultNull
     * @return array<int, string>|null
     */
    public function asList(string $separator = " ", ?int $limit = null, ?array $defaultNull = null): ?array
    {
        if ($this->valueAsString == null) {
            return $defaultNull;
        }
        if ($limit == null) {
            return explode($separator, $this->valueAsString);
        }
        return explode($separator, $this->valueAsString, $limit);
    }

    /**
     * Returns the value as a CSV array or null.
     * @param array|null $defaultNull
     * @return array<int, string>|null
     */
    public function asCsv(?array $defaultNull = null): ?array
    {
        return $this->asList(",", null, $defaultNull);
    }

    /**
     * Returns the value as a string or the given default if not available.
     * @param string|null $defaultNull
     */
    public function asString(?string $defaultNull = null): ?string
    {
        return $this->valueAsString ?? $defaultNull;
    }

    /**
     * Returns the value as a float or the given default if not available.
     * @param float|null $defaultNull
     */
    public function asFloat(?float $defaultNull = null): ?float
    {
        return $this->valueAsFloat ?? $defaultNull;
    }

    /**
     * Returns the value as an int or the given default if not available.
     * @param int|null $defaultNull
     */
    public function asInt(?int $defaultNull = null): ?int
    {
        return $this->valueAsInt ?? $defaultNull;
    }

    /**
     * Returns the value as a boolean or the given default if not available.
     * @param bool|null $defaultNull
     */
    public function asBool(?bool $defaultNull = null): bool
    {
        return $this->valueAsBool ?? $defaultNull;
    }

    /**
     * Returns the value as an array or the given default if not available.
     * @param array|null $defaultNull
     * @return array<int, mixed>|null
     */
    public function asArray(?array $defaultNull = null): ?array
    {
        return $this->valueAsArray ?? $defaultNull;
    }
}
