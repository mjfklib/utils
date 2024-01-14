<?php

declare(strict_types=1);

namespace mjfklib\Utils;

final class JSON
{
    /**
     * @param mixed $value
     * @param int<1,max> $depth
     * @param int $flags
     * @return string
     */
    public static function encode(
        mixed $value,
        int $depth = 512,
        int $flags = JSON_PRETTY_PRINT,
    ): string {
        return json_encode(
            $value,
            $flags | JSON_THROW_ON_ERROR,
            $depth
        );
    }


    /**
     * @param string $json
     * @param int<1,max> $depth
     * @param int $flags
     * @return mixed[]
     */
    public static function decodeArray(
        string $json,
        int $depth = 512,
        int $flags = 0,
    ): array {
        $value = json_decode(
            $json,
            true,
            $depth,
            $flags | JSON_THROW_ON_ERROR
        );

        return is_array($value)
            ? $value
            : throw new \RuntimeException("Decoded JSON is not an array");
    }


    /**
     * @param string $json
     * @param int<1,max> $depth
     * @param int $flags
     * @return \stdClass
     */
    public static function decodeObject(
        string $json,
        int $depth = 512,
        int $flags = 0,
    ): \stdClass {
        $value = json_decode(
            $json,
            false,
            $depth,
            $flags | JSON_THROW_ON_ERROR
        );

        return $value instanceof \stdClass
            ? $value
            : throw new \RuntimeException("Decoded JSON is not an object");
    }
}
