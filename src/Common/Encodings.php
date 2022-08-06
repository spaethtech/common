<?php /** @noinspection PhpUnused */
declare(strict_types=1);

namespace MVQN\Common;

final class Encodings
{

    public static function isBase64Encoded(string $data): bool
    {
        if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $data))
            return true;
        else
            return false;
    }




}

