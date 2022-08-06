<?php /** @noinspection PhpUnused */
declare(strict_types=1);

namespace SpaethTech\Composer\Scripts;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;
use SpaethTech\Common\FileSystem;

class Terminal
{
    public static function postUpdate(Event $event)
    {
        //$composer = $event->getComposer();

        $vendorDir = $event->getComposer()->getConfig()->get("vendor-dir");
        require $vendorDir."/autoload.php";

        //if (!defined("PROJECT_DIR"))
        //    include_once __DIR__."/../../../inc/globals.inc.php";

        //$event->getIO()->write(PROJECT_DIR, TRUE);
        if (($ide = realpath(__DIR__."/../../../ide")) && $ide !== PROJECT_DIR)
            //FileSystem::copyDir(__DIR__."/../../../ide", PROJECT_DIR."/ide", TRUE);
            $event->getIO()->write(PROJECT_DIR, TRUE);

    }



}
