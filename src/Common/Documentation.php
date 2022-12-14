<?php /** @noinspection PhpUnused */
declare(strict_types=1);

namespace SpaethTech\Common;

use Composer\Script\Event;

/**
 * Class Documentation
 *
 * @package SpaethTech\Common
 */
final class Documentation
{
    /**
     * @param Event $event
     */
    public static function generate(Event $event)
    {
        $arguments = $event->getArguments();
        $pwd = exec("echo %cd%");

        $root = count($arguments) > 0 ? (realpath($arguments[0]) ?: $pwd) : $pwd;

        $phar = realpath(__DIR__ . "/../../../lib/phpDocumentor.phar");
        echo "Clearing existing output...";
        echo exec("IF EXIST $root\\docs\\ RMDIR $root\\docs\\ /S /Q");
        echo "Complete!\n";

        $args = "-d $root\\src\\ -t $root\\docs\\ --cache-folder $root\\docs\\.cache\\ --template=xml";

        if(file_exists($root . "\\phpdoc.dist.xml") || file_exists($root . "\\phpdoc.xml"))
        {
            // TODO: Get path information for the "phpdocmd" command...

            $args = "";
        }

        echo "Running phpdoc via PHAR file '$phar'...\n";
        echo exec("php $phar $args");
        echo "\n";

        //echo exec("docker run --rm -v $root:/data phpdoc/phpdoc -t /data/src/ -d /data/docs/ --cache-folder /data/docs/.cache/");


        echo "Running phpdoc-md...";
        echo exec("php bin\\phpdoc-md $root\\docs\\structure.xml $root\\docs\\");
        echo "!\n";
    }




}
