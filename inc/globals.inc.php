<?php /** @noinspection PhpUnused */
declare(strict_types=1);

if (!defined("PROJECT_DIR"))
{
    // IF this script is nested in the vendor directory...
    if (($vendor = realpath(__DIR__."/../../../")) && dirname($vendor) === "vendor")
        // ..THEN this library has been required in another project, go up one directory!
        define("PROJECT_DIR", realpath($vendor."/../"));
    else
        // ...OTHERWISE, this is the library itself!
        define("PROJECT_DIR", realpath(__DIR__."/../"));
}


#if (!defined("IDE_DIR"))
#    define("IDE_DIR", realpath(__DIR__."/../"));

