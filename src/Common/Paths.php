<?php /** @noinspection PhpUnused */
declare(strict_types=1);

namespace SpaethTech\Common;

final class Paths
{
    /**
     * @param string $path
     * @param string $separator
     * @return string
     */
    public static function canonicalize(string $path, string $separator = DIRECTORY_SEPARATOR): string
    {
        $path = explode($separator, $path);
        $stack = array();
        foreach ($path as $seg) {
            if ($seg == '..') {
                // Ignore this segment, remove last segment from stack
                array_pop($stack);
                continue;
            }

            if ($seg == '.') {
                // Ignore this segment
                continue;
            }

            $stack[] = $seg;
        }

        return implode($separator, $stack);
    }


}