<?php
declare(strict_types=1);

if (!defined("PROJECT_DIR")) {
    // IF this script is nested in the vendor directory...
    if (($vendor = realpath(__DIR__ . "/../../../")) && basename($vendor) === "vendor")
        // ...THEN this library has been required in another project, go up one directory!
        define("PROJECT_DIR", realpath($vendor . "/../"));
    else
        // ...OTHERWISE, this is the library itself!
        define("PROJECT_DIR", realpath(__DIR__ . "/../"));
}
