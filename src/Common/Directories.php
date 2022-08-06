<?php /** @noinspection PhpUnused */
declare(strict_types=1);

namespace MVQN\Common;

/**
 * A collection of helper functions for directory manipulation.
 *
 * @package MVQN\Common
 */
final class Directories
{
    /**
     * @param string $dir
     * @param bool $recursive
     */
    public static function rmdir(string $dir, bool $recursive = false)
    {


        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . "/" . $object) && $recursive)
                        self::rmdir($dir . "/" . $object, $recursive);
                    else
                        unlink($dir . "/" . $object);
                }
            }
            rmdir($dir);
        }
    }


    /**
     * @param string $root
     * @param callable|null $func
     * @return array|false
     */
    public static function scanDirMap(string $root, callable $func = null)
    {
        return $func ? array_map($func, self::scanDir($root)) : self::scanDir($root);
    }

    /**
     * @param string $root
     * @param callable|null $func
     * @return array|false
     */
    public static function scanDirFilter(string $root, callable $func = null)
    {
        return $func ? array_filter(self::scanDir($root), $func) : self::scanDir($root);
    }

    /**
     * @param string $root
     * @return array|false
     */
    public static function scanDir(string $root)
    {
        $rootReal = realpath($root);

        if(!$rootReal || !is_dir($rootReal))
            return false;

        $results = [];

        foreach(scandir($rootReal) as $filename)
        {
            if ($filename === "." || $filename === "..")
                continue;

            $filePath = $rootReal . DIRECTORY_SEPARATOR . $filename;

            if (is_dir($filePath))
            {
                foreach (self::scanDir($filePath) as $childFilename)
                {
                    $results[] = $filename . DIRECTORY_SEPARATOR . $childFilename;
                }
            }
            else
            {
                $results[] = $filename;
            }
        }

        return $results;
    }




}