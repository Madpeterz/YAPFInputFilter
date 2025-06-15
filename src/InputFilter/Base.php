<?php

namespace YAPF\InputFilter;

use YAPF\Core\ErrorControl\ErrorLogging as ErrorLogging;

/**
 * Abstract base class for input filtering and conversion.
 * Handles value conversion, error logging, and provides methods for fetching input from various sources.
 */
abstract class Base extends ErrorLogging
{
    /**
     * Stores the reason for the last failure.
     * @var string
     */
    protected string $whyfailed = "";
    /**
     * Stores the value as a string, if possible.
     * @var string|null
     */
    protected ?string $valueAsString = null;
    /**
     * Stores the value as an integer, if possible.
     * @var int|null
     */
    protected ?int $valueAsInt = null;
    /**
     * Stores the value as a float, if possible.
     * @var float|null
     */
    protected ?float $valueAsFloat = null;
    /**
     * Stores the value as a boolean, if possible.
     * @var bool
     */
    protected bool $valueAsBool = false;
    /**
     * Stores the value as an array, if possible.
     * @var array|null
     */
    protected ?array $valueAsArray = null;
    /**
     * Stores the value in a human-readable format, if available.
     * @var string|null
     */
    protected ?string $valueAsHumanReadable = null;

    /**
     * Resets all value properties and sets failure reason to 'in reset mode'.
     */
    protected function reset(): void
    {
        $this->whyfailed = "in reset mode";
        $this->valueAsBool = false;
        $this->valueAsInt = null;
        $this->valueAsString = null;
        $this->valueAsFloat = null;
        $this->valueAsArray = null;
        $this->valueAsHumanReadable = null;
    }

    /**
     * Returns the last stored fail message.
     */
    public function getWhyFailed(): string
    {
        return $this->whyfailed;
    }

    /**
     * Sets the failure reason, resets values, and logs the error.
     * @param string $why Reason for failure
     */
    protected function failed(string $why): void
    {
        $this->reset();
        $this->addError($why);
        $this->whyfailed = $why;
    }

    /**
     * Fetches and converts a value from the $_POST array by field name.
     * @param string $field The field name to fetch from $_POST
     */
    public function post(string $field): InputFilter
    {
        $this->reset();
        if (array_key_exists($field, $_POST) == false) {
            return $this;
        }
        $this->convertValue("post", $field);
        return $this;
    }

    /**
     * Fetches and converts a value from the $_GET array by field name.
     * @param string $field The field name to fetch from $_GET
     */
    public function get(string $field): InputFilter
    {
        $this->reset();
        if (array_key_exists($field, $_GET) == false) {
            return $this;
        }
        $this->convertValue("get", $field);
        return $this;
    }

    /**
     * Fetches and converts a value from the $_ENV array by field name.
     * @param string $field The field name to fetch from $_ENV
     */
    public function envInput(string $field): InputFilter
    {
        $this->reset();
        if (array_key_exists($field, $_ENV) == false) {
            return $this;
        }
        $this->convertValue("env", $field);
        return $this;
    }

    /**
     * Converts a direct variable input value.
     * @param string|null $value The value to convert
     */
    public function varInput(?string $value): InputFilter
    {
        $this->reset();
        $this->convertValue("", "", $value);
        return $this;
    }

    /**
     * Fetches a value from the specified source and field.
     * @param string $source The source type: 'post', 'get', or 'env'
     * @param string $field The field name to fetch
     * @return mixed string|array|null
     */
    protected function fetchValue(string $source, string $field): mixed
    {
        $sourceDat = [];
        if ($source == "post") {
            $sourceDat = &$_POST;
        } elseif ($source == "get") {
            $sourceDat = &$_GET;
        } elseif ($source == "env") {
            $sourceDat = &$_ENV;
        }
        if (array_key_exists($field, $sourceDat) == false) {
            return null;
        }
        return $sourceDat[$field];
    }

    /**
     * Converts the value from the specified source and field, or uses the provided value.
     * Sets the value properties accordingly.
     * @param string $source The source type: 'post', 'get', or 'env'
     * @param string $field The field name to fetch
     * @param string|null $value The value to convert (optional)
     */
    protected function convertValue(string $source, string $field, ?string $value = null): void
    {
        if ($value == null) {
            $value = $this->fetchValue($source, $field);
        }
        if ($value === null) {
            return;
        }
        $this->valueAsArray = null;
        if (is_array($value) == true) {
            $this->valueAsArray = $value;
            $value = json_encode($value);
        }
        $this->valueAsString = htmlentities($value);
        $this->valueAsInt = intval($this->valueAsString);
        $this->valueAsFloat = floatval($this->valueAsString);
        $this->valueAsBool = in_array(
            $this->valueAsString,
            ["1","true",true,1,"yes","True","TRUE"],
            true
        );
    }
}
