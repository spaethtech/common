<?php
declare(strict_types=1);

namespace SpaethTech\Common;

use SpaethTech\Common\Exceptions\ArrayTraversalException;

class ArrayIndexer
{
    protected $container;


    public function __construct(array $container)
    {
        $this->container = $container;
    }


    /**
     * @param string $path The path to use during traversal, represented by dot-notation.
     * @param null $default The value to return on a non-existent path, or when omitted, throws an Exception.
     * @return mixed Returns the value at the successfully traversed index or the specified default on failure.
     * @throws ArrayTraversalException
     */
    public function getByDotNotation(string $path, $default = null)
    {
        $steps = explode(".", $path);

        try
        {
            $value = self::arrayPath($this->container, $steps);
        }
        catch(ArrayTraversalException $e)
        {
            if(!array_key_exists(1, func_get_args()))
                throw $e;

            return $default;
        }

        return $value;
    }

    public function setByDotNotation(string $path, $value): void
    {
        $steps = explode(".", $path);
        self::arrayPath($this->container, $steps, $value);
    }




    public function toArray(): array
    {
        return $this->container;
    }






    private static function arrayPath(array &$array, array $path, &$value = null)
    {
        $args = func_get_args();
        $ref = &$array;

        foreach ($path as $key)
        {
            if (!is_array($ref))
                $ref = [];

            if (!array_key_exists($key, $ref) && !array_key_exists(2, $args))
            {
                throw new ArrayTraversalException(
                    "Array traversal using '".(implode(".", $path))."' failed at '$key'!");
            }

            $ref = &$ref[$key];
        }

        $prev = $ref;

        if (array_key_exists(2, $args))
        {
            // value param was passed -> we're setting
            $ref = $value;  // set the value
        }

        return $prev;
    }




}
