<?php

namespace YAPF\InputFilter;

/**
 * Class Checks
 * Provides various validation and checking methods for input values.
 */
abstract class Checks extends Base
{
    /**
     * Checks if the value starts with the given needle.
     * @param string $needle
     */
    public function checkStartsWith(string $needle): InputFilter
    {
        if ($this->valueAsString == null) {
            return $this;
        }
        $pos = strpos($this->valueAsString, $needle);
        if ($pos === false) {
            $this->failed("Missing " . $needle . " from the string!");
        } elseif ($pos != 0) {
            $this->failed("Does not start with " . $needle);
        }
        return $this;
    }

    /**
     * Checks if the value ends with the given needle.
     * @param string $needle
     */
    public function checkEndsWith(string $needle): InputFilter
    {
        if ($this->valueAsString == null) {
            return $this;
        }
        $length = strlen($needle);
        if ($length == 0) {
            return $this;
        }
        if (substr($this->valueAsString, 0 - $length) === $needle) {
            return $this;
        }
        $this->failed("Does not end with " . $needle);
        return $this;
    }

    /**
     * Checks if the value is within the given float range.
     * @param float|null $min
     * @param float|null $max
     */
    public function checkInRange(?float $min, ?float $max): InputFilter
    {
        if ($this->valueAsFloat == null) {
            return $this;
        }
        if (($min == null) || ($max == null)) {
            return $this;
        }
        if (($this->valueAsFloat < $min) || ($this->valueAsFloat > $max)) {
            $this->failed("Not in range: " . round($min, 2) . " to " . round($max));
        }
        return $this;
    }

    /**
     * Checks if the value is greater than or equal to the given minimum.
     * @param float $min
     */
    public function checkGrtThanEq(float $min): InputFilter
    {
        if ($this->valueAsFloat == null) {
            return $this;
        }
        if ($this->valueAsFloat < $min) {
            $this->failed("Less than: " . round($min, 2));
        }
        return $this;
    }

    /**
     * Checks if the value is less than or equal to the given maximum.
     * @param float $max
     */
    public function checkLessThanEq(float $max): InputFilter
    {
        if ($this->valueAsFloat == null) {
            return $this;
        }
        if ($this->valueAsFloat > $max) {
            $this->failed("More than: " . round($max, 2));
        }
        return $this;
    }

    /**
     * Checks if the value matches the given regex.
     * @param string $regex
     */
    public function checkMatchRegex(string $regex): InputFilter
    {
        if ($this->valueAsString == null) {
            return $this;
        }
        if (!preg_match($regex, $this->valueAsString)) {
            $this->failed("Did not match regex check");
        }
        return $this;
    }

    /**
     * Checks if the string length is within the given min and max.
     * @param int|null $min
     * @param int|null $max
     */
    public function checkStringLength(?int $min, ?int $max): InputFilter
    {
        if ($this->valueAsString == null) {
            return $this;
        }
        if (($min == null) || ($max == null)) {
            return $this;
        }
        $len = strlen($this->valueAsString);
        if (($len < $min) || ($len > $max)) {
            $this->failed("Invaild length of " . $len . " expected " . $min . " to " . $max);
        }
        return $this;
    }

    /**
     * Checks if the string length is at least the given minimum.
     * @param int|null $min
     */
    public function checkStringLengthMin(?int $min): InputFilter
    {
        if ($this->valueAsString == null) {
            return $this;
        }
        if ($min == null) {
            return $this;
        }
        $len = strlen($this->valueAsString);
        if ($len < $min) {
            $this->failed("Invaild length of " . $len . " expected longer than " . $min);
        }
        return $this;
    }

    /**
     * Checks if the string length is at most the given maximum.
     * @param int|null $max
     */
    public function checkStringLengthMax(?int $max): InputFilter
    {
        if ($this->valueAsString == null) {
            return $this;
        }
        if ($max == null) {
            return $this;
        }
        $len = strlen($this->valueAsString);
        if ($len > $max) {
            $this->failed("Invaild length of " . $len . " expected less than " . $max);
        }
        return $this;
    }
}
