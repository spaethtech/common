<?php /** @noinspection PhpUnused */
declare(strict_types=1);

namespace SpaethTech\Documentation;

use Twig_Environment;
use Twig_Loader_Filesystem;
use Twig_SimpleFilter;

/**
 * This class takes the output from 'parser', and generate the markdown
 * templates.
 *
 * @copyright Copyright (C) Evert Pot. All rights reserved.
 * @author    Evert Pot (https://evertpot.coom/)
 * @license   MIT
 */
class Generator
{
    /**
     * Output directory.
     *
     * @var string
     */
    protected string $outputDir;

    /**
     * The list of classes and interfaces.
     *
     * @var array
     */
    protected array $classDefinitions;

    /**
     * Directory containing the twig templates.
     *
     * @var string
     */
    protected string $templateDir;

    /**
     * A simple template for generating links.
     *
     * @var string
     */
    protected string $linkTemplate;

    /**
     * Filename for API Index.
     *
     * @var string
     */
    protected string $apiIndexFile;

    /**
     * @param array  $classDefinitions
     * @param string $outputDir
     * @param string $templateDir
     * @param string $linkTemplate
     * @param string $apiIndexFile
     */
    function __construct(array $classDefinitions, string $outputDir, string $templateDir, string $linkTemplate = '%c.md', string $apiIndexFile = 'ApiIndex.md')
    {
        $this->classDefinitions = $classDefinitions;
        $this->outputDir = $outputDir;
        $this->templateDir = $templateDir;
        $this->linkTemplate = $linkTemplate;
        $this->apiIndexFile = $apiIndexFile;
    }

    /**
     * Starts the generator.
     */
    function run()
    {
        $loader = new Twig_Loader_Filesystem(
            $this->templateDir,
            $this->outputDir
            /*
            [
            'cache' => false,
            'debug' => true,
            ]
            */
        );

        $twig = new Twig_Environment($loader);

        $GLOBALS['SpaethTech_Documentation_classDefinitions'] = $this->classDefinitions;
        $GLOBALS['SpaethTech_Documentation_linkTemplate'] = $this->linkTemplate;

        $filter = new Twig_SimpleFilter('classLink', ['rspaeth\\Documentation\\Generator', 'classLink']);
        $twig->addFilter($filter);
    
    
        /** @noinspection PhpUnusedLocalVariableInspection */
        foreach ($this->classDefinitions as $className => $data) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $output = $twig->render('class.twig', $data);

            file_put_contents($this->outputDir . '/' . $data['fileName'], $output);
        }

        $index = $this->createIndex();
    
        /** @noinspection PhpUnhandledExceptionInspection */
        $index = $twig->render('index.twig',
            [
                'index'            => $index,
                'classDefinitions' => $this->classDefinitions,
            ]
        );

        file_put_contents($this->outputDir . '/' . $this->apiIndexFile, $index);
    }

    /**
     * Creates an index of classes and namespaces.
     *
     * I'm generating the actual markdown output here, which isn't great...But it will have to do.
     * If I don't want to make things too complicated.
     *
     *
     */
    protected function createIndex(): string
    {
        $tree = [];

        foreach ($this->classDefinitions as $className => $classInfo) {
            $current = & $tree;

            foreach (explode('\\', $className) as $part) {
                if (!isset($current[$part])) {
                    $current[$part] = [];
                }

                $current = & $current[$part];
            }
        }

        /**
         * This will be a reference to the $treeOutput closure, so that it can be invoked
         * recursively. A string is used to trick static analysers into thinking this might be
         * callable.
         */
        $treeOutput = '';

        $treeOutput = function($item, $fullString = '', $depth = 0) use (&$treeOutput) {
            $output = '';

            foreach ($item as $name => $subItems) {
                $fullName = $name;

                if ($fullString) {
                    $fullName = $fullString . '\\' . $name;
                }

                $output .= str_repeat(' ', $depth * 4) . '* ' . Generator::classLink($fullName, $name) . "\n";
                $output .= $treeOutput($subItems, $fullName, $depth + 1);
            }

            return $output;
        };

        return $treeOutput($tree);
    }

    /**
     * This is a twig template function.
     *
     * This function allows us to easily link classes to their existing pages.
     *
     * Due to the unfortunate way twig works, this must be static, and we must use a global to
     * achieve our goal.
     *
     * @param string      $className
     * @param null|string $label
     *
     * @return string
     */
    static function classLink(string $className, ?string $label = null): string
    {
        $classDefinitions = $GLOBALS['SpaethTech_Documentation_classDefinitions'];
        $linkTemplate = $GLOBALS['SpaethTech_Documentation_linkTemplate'];

        $returnedClasses = [];

        foreach (explode('|', $className) as $oneClass) {
            $oneClass = trim($oneClass, '\\ ');

            if (!$label) {
                $label = $oneClass;
            }

            if (!isset($classDefinitions[$oneClass])) {
                $returnedClasses[] = $oneClass;
            } else {
                $link = str_replace('\\', '-', $oneClass);
                $link = strtr($linkTemplate, ['%c' => $link]);

                $returnedClasses[] = sprintf("[%s](%s)", $label, $link);
            }
        }

        return implode('|', $returnedClasses);
    }
}
