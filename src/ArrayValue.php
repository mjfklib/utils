<?php

declare(strict_types=1);

namespace mjfklib\Utils;

class ArrayValue
{
    /**
     * @param mixed $value
     * @return mixed[]
     */
    public static function convertToArray(mixed $value): array
    {
        $value = static::getArrayValue($value);
        return $value ?? throw new \ValueError("Unable to convert to array");
    }


    /**
     * @param mixed $value
     * @return array<string,string>
     */
    public static function convertToStringArray(mixed $value): array
    {
        $value = static::getStringArrayValue($value);
        return $value ?? throw new \ValueError("Unable to convert to string array");
    }


/**********************************************************************************************************************/


    /**
     * @param mixed[] $values
     * @param string|string[] $name
     * @return bool
     */
    public static function getBool(
        array $values,
        string|array $name
    ): bool {
        return static::getValue(
            $values,
            $name,
            fn ($v) => is_bool($v),
            fn ($v) => static::getBoolValue($v) ?? throw static::err($name)
        );
    }


    /**
     * @param mixed[] $values
     * @param string|string[] $name
     * @return bool|null
     */
    public static function getBoolNull(
        array $values,
        string|array $name
    ): bool|null {
        return static::getValue(
            $values,
            $name,
            fn ($v) => is_bool($v) || is_null($v),
            fn ($v) => static::getBoolValue($v) ?? static::getNullValue($name, $v)
        );
    }


    /**
     * @param mixed[] $values
     * @param string|string[] $name
     * @return float
     */
    public static function getFloat(
        array $values,
        string|array $name
    ): float {
        return static::getValue(
            $values,
            $name,
            fn ($v) => is_float($v),
            fn ($v) => static::getFloatValue($v) ?? throw static::err($name)
        );
    }


    /**
     * @param mixed[] $values
     * @param string|string[] $name
     * @return float|null
     */
    public static function getFloatNull(
        array $values,
        string|array $name
    ): float|null {
        return static::getValue(
            $values,
            $name,
            fn ($v) => is_float($v) || is_null($v),
            fn ($v) => static::getFloatValue($v) ?? static::getNullValue($name, $v)
        );
    }


    /**
     * @param mixed[] $values
     * @param string|string[] $name
     * @return int
     */
    public static function getInt(
        array $values,
        string|array $name
    ): int {
        return static::getValue(
            $values,
            $name,
            fn ($v) => is_int($v),
            fn ($v) => static::getIntValue($v) ?? throw static::err($name)
        );
    }


    /**
     * @param mixed[] $values
     * @param string|string[] $name
     * @return int|null
     */
    public static function getIntNull(
        array $values,
        string|array $name
    ): int|null {
        return static::getValue(
            $values,
            $name,
            fn ($v) => is_int($v) || is_null($v),
            fn ($v) => static::getIntValue($v) ?? static::getNullValue($name, $v)
        );
    }


    /**
     * @param mixed[] $values
     * @param string|string[] $name
     * @return string
     */
    public static function getString(
        array $values,
        string|array $name
    ): string {
        return static::getValue(
            $values,
            $name,
            fn ($v) => is_string($v),
            fn ($v) => static::getStringValue($v) ?? throw static::err($name)
        );
    }


    /**
     * @param mixed[] $values
     * @param string|string[] $name
     * @return string|null
     */
    public static function getStringNull(
        array $values,
        string|array $name
    ): string|null {
        return static::getValue(
            $values,
            $name,
            fn ($v) => is_string($v) || is_null($v),
            fn ($v) => static::getStringValue($v) ?? static::getNullValue($name, $v)
        );
    }


    /**
     * @param mixed[] $values
     * @param string|string[] $name
     * @return mixed[]
     */
    public static function getArray(
        array $values,
        string|array $name
    ): array {
        return static::getValue(
            $values,
            $name,
            fn ($v) => is_array($v),
            fn ($v) => static::getArrayValue($v) ?? throw static::err($name)
        );
    }


    /**
     * @param mixed[] $values
     * @param string|string[] $name
     * @return mixed[]|null
     */
    public static function getArrayNull(
        array $values,
        string|array $name
    ): array|null {
        return static::getValue(
            $values,
            $name,
            fn ($v) => is_array($v) || is_null($v),
            fn ($v) => static::getArrayValue($v) ?? static::getNullValue($name, $v)
        );
    }


    /**
     * @param mixed[] $values
     * @param string|string[] $name
     * @return array<string,string>
     */
    public static function getStringArray(
        array $values,
        string|array $name
    ): array {
        return static::getValue(
            $values,
            $name,
            fn () => false,
            fn ($v) => static::getStringArrayValue($v) ?? throw static::err($name)
        );
    }


    /**
     * @param mixed[] $values
     * @param string|string[] $name
     * @return array<string,string>|null
     */
    public static function getStringArrayNull(
        array $values,
        string|array $name
    ): array|null {
        return static::getValue(
            $values,
            $name,
            fn () => false,
            fn ($v) => static::getStringArrayValue($v) ?? static::getNullValue($name, $v)
        );
    }


    /**
     * @param mixed[] $values
     * @param string|string[] $name
     * @return object
     */
    public static function getObject(
        array $values,
        string|array $name
    ): object {
        return static::getValue(
            $values,
            $name,
            fn ($v) => is_object($v),
            fn ($v) => static::getObjectValue($v) ?? throw static::err($name)
        );
    }


    /**
     * @param mixed[] $values
     * @param string|string[] $name
     * @return object|null
     */
    public static function getObjectNull(
        array $values,
        string|array $name
    ): object|null {
        return static::getValue(
            $values,
            $name,
            fn ($v) => is_object($v),
            fn ($v) => static::getObjectValue($v) ?? static::getNullValue($name, $v)
        );
    }


    /**
     * @param mixed[] $values
     * @param string|string[] $name
     * @return \DateTimeInterface
     */
    public static function getDateTime(
        array $values,
        string|array $name
    ): \DateTimeInterface {
        return static::getValue(
            $values,
            $name,
            fn ($v) => $v instanceof \DateTimeInterface,
            fn ($v) => static::getDateTimeValue($v) ??  throw static::err($name)
        );
    }


    /**
     * @param mixed[] $values
     * @param string|string[] $name
     * @return \DateTimeInterface|null
     */
    public static function getDateTimeNull(
        array $values,
        string|array $name
    ): \DateTimeInterface|null {
        return static::getValue(
            $values,
            $name,
            fn ($v) => $v instanceof \DateTimeInterface || is_null($v),
            fn ($v) => static::getDateTimeValue($v) ?? static::getNullValue($name, $v)
        );
    }


    /**
     * @param mixed[] $values
     * @param string|string[] $name
     * @return resource
     */
    public static function getResource(
        array $values,
        string|array $name
    ): mixed {
        return static::getValue(
            $values,
            $name,
            fn ($v) => is_resource($v),
            fn ($v) => is_resource($v) ? $v : throw static::err($name)
        );
    }


    /**
     * @param mixed[] $values
     * @param string|string[] $name
     * @return resource|null
     */
    public static function getResourceNull(
        array $values,
        string|array $name
    ): mixed {
        return static::getValue(
            $values,
            $name,
            fn ($v) => is_resource($v) || is_null($v),
            fn ($v) => is_resource($v) ? $v : static::getNullValue($name, $v)
        );
    }


/**********************************************************************************************************************/


    /** @var array<int,string> */
    protected const TRUE_VALUES = [
        '1',
        'ON',
        'T',
        'TRUE',
        'X',
        'Y',
        'YES'
    ];


    /**
     * @param string|string[] $name
     * @return \ValueError
     */
    protected static function err(string|array $name): \ValueError
    {
        if (is_array($name)) {
            $name = implode(",", $name);
        }
        return new \ValueError("Unable to get value: {$name}");
    }


    /**
     * @template T
     * @param mixed[] $values
     * @param string|string[] $name
     * @param (callable(mixed $v): bool) $isValue
     * @param (callable(mixed $v): T) $castValue
     * @return T
     */
    protected static function getValue(
        array $values,
        string|array $name,
        callable $isValue,
        callable $castValue
    ): mixed {
        if (is_string($name)) {
            $value = $values[$name] ?? null;
            if (!$isValue($value)) {
                $value = $castValue($value);
            }
            /** @var T $value */
            return $value;
        }

        foreach ($name as $n) {
            try {
                $value = $values[$n] ?? null;
                if (!$isValue($value)) {
                    $value = $castValue($value);
                }
                /** @var T $value */
                return $value;
            } catch (\ValueError) {
            }
        }

        throw self::err($name);
    }


    /**
     * @param string|string[] $name
     * @param mixed $value
     * @return null
     */
    protected static function getNullValue(
        string|array $name,
        mixed $value
    ): null {
        return is_null($value) ? null : throw static::err($name);
    }


    /**
     * @param mixed $value
     * @return bool|null
     */
    protected static function getBoolValue(mixed $value): bool|null
    {
        return is_scalar($value) ? in_array(strtoupper(strval($value)), static::TRUE_VALUES, true) : null;
    }


    /**
     * @param mixed $value
     * @return float|null
     */
    protected static function getFloatValue(mixed $value): float|null
    {
        return is_scalar($value) ? floatval($value) : null;
    }


    /**
     * @param mixed $value
     * @return int|null
     */
    protected static function getIntValue(mixed $value): int|null
    {
        return is_scalar($value) ? intval($value) : null;
    }


    /**
     * @param mixed $value
     * @return string|null
     */
    protected static function getStringValue(mixed $value): string|null
    {
        return is_scalar($value) ? strval($value) : null;
    }


    /**
     * @param mixed $value
     * @return mixed[]|null
     */
    protected static function getArrayValue(mixed $value): array|null
    {
        return match (true) {
            is_array($value) => $value,
            is_object($value) => get_object_vars($value),
            is_string($value) => JSON::decodeArray(
                is_file($value)
                    ? FileMethods::getContents($value)
                    : $value
            ),
            default => null
        };
    }


    /**
     * @param mixed $value
     * @return array<string,string>|null
     */
    protected static function getStringArrayValue(mixed $value): array|null
    {
        $value = static::getArrayValue($value);
        if (!is_array($value)) {
            return null;
        }

        $value = array_filter(
            $value,
            fn ($v) => is_scalar($v) || $v instanceof \Stringable
        );

        return array_column(
            array_map(
                fn ($v, $k) => [strval($v), strval($k)],
                array_values($value),
                array_keys($value)
            ),
            0,
            1
        );
    }


    /**
     * @param mixed $value
     * @return object|null
     */
    protected static function getObjectValue(mixed $value): object|null
    {
        return match (true) {
            is_object($value) => $value,
            is_array($value) => (object)$value,
            is_string($value) => JSON::decodeObject(
                is_file($value)
                    ? FileMethods::getContents($value)
                    : $value
            ),
            default => null
        };
    }


    /**
     * @param mixed $value
     * @return \DateTimeInterface
     */
    protected static function getDateTimeValue(mixed $value): \DateTimeInterface|null
    {
        return match (true) {
            is_object($value) && $value instanceof \DateTimeInterface => $value,
            is_int($value) => new \DateTimeImmutable(date('c', $value)),
            is_string($value) => new \DateTimeImmutable($value),
            default => null
        };
    }
}
