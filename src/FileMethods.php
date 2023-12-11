<?php

declare(strict_types=1);

namespace mjfklib\Utils;

class FileMethods
{
    /**
     * @param string $pattern
     * @param int $flags
     * @return string[]
     */
    public static function glob(
        string $pattern,
        int $flags = 0
    ): array {
        $matches = glob($pattern, $flags);
        return is_array($matches)
            ? $matches
            : throw new \RuntimeException("Invalid glob pattern: {$pattern}");
    }


    /**
     * @param string $path
     * @return string
     */
    public static function getRealPath(string $path): string
    {
        $realPath = realpath($path);
        return is_string($realPath)
            ? $realPath
            : throw new \RuntimeException("Invalid path: {$path}");
    }


    /**
     * @param string $path
     * @param string $ext
     * @return array<string,string>
     */
    public static function getFiles(
        string $path,
        string $ext
    ): array {
        $ext = ltrim($ext, ".");
        $offset = strlen($ext) > 0 ? -1 * (strlen($ext) + 1) : 0;

        return array_column(
            array_map(
                fn (string $f): array => [
                    $offset < 0 ? substr($f, 0, $offset) : $f,
                    $f
                ],
                array_filter(
                    static::glob("{$path}/*.{$ext}"),
                    'is_file'
                )
            ),
            0,
            1
        );
    }


    /**
     * @param string $pattern
     * @param int $flags
     * @return void
     */
    public static function deleteFiles(
        string $pattern,
        int $flags = 0
    ): void {
        array_map(
            'unlink',
            array_filter(
                static::glob($pattern, $flags),
                'is_file'
            )
        );
    }


    /**
     * @param string $path
     * @return string
     */
    public static function getContents(string $path): string
    {
        if (!is_file($path)) {
            throw new \RuntimeException("File not found: {$path}");
        }
        if (!is_readable($path)) {
            throw new \RuntimeException("File not readable: {$path}");
        }

        $contents = file_get_contents($path);
        return is_string($contents)
            ? $contents
            : throw new \RuntimeException("Error reading from file: {$path}");
    }


    /**
     * @param string $path
     * @param string|string[] $contents
     * @return int
     */
    public static function putContents(
        string $path,
        string|array $contents
    ): int {
        $contents = (is_array($contents) ? implode("\n", $contents) : $contents) . "\n";
        $bytes = file_put_contents($path, $contents);
        return $bytes === strlen($contents)
            ? $bytes
            : throw new \RuntimeException("Error writing to file: {$path}");
    }


    /**
     * @param string $path
     * @param bool $stripBOM
     * @return array{0:\ZipArchive,1:resource}
     */
    public static function openZipFile(
        string $path,
        bool $stripBOM = true
    ): array {
        $zipFile = new \ZipArchive();
        if ($zipFile->open($path) !== true) {
            throw new \RuntimeException("Unable to open zip file: {$path}");
        }

        $zipFileStream = $zipFile->getStream(strval($zipFile->getNameIndex(0)));
        if (!is_resource($zipFileStream)) {
            throw new \RuntimeException("Unable to open zip file: {$path}");
        }

        // Strip byte order mark (BOM)
        if ($stripBOM) {
            fread($zipFileStream, 3);
        }

        return [$zipFile, $zipFileStream];
    }


    /**
     * @param string $path
     * @param string $mode
     * @return resource
     */
    public static function openGzipFile(
        string $path,
        string $mode = 'w9'
    ): mixed {
        $gzipFile = gzopen($path, $mode);
        return is_resource($gzipFile)
            ? $gzipFile
            : throw new \RuntimeException("Unable to open gzip file: {$path}");
    }


    /**
     * @param string $path
     * @param string $mode
     * @return resource
     */
    public static function openFile(
        string $path,
        string $mode
    ): mixed {
        $file = fopen($path, $mode);
        return is_resource($file)
            ? $file
            : throw new \RuntimeException("Unable to open file: {$path}");
    }
}
