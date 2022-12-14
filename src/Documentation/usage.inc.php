PHPDocumentor Markdown Generator

Usage:

    # First generate a structure.xml file with phpDocumentor.
    # This command will generate structure.xml in the docs directory
    phpdoc -d [project path] -t docs/ --template="xml"

    # Next, run phpdocmd:
    <?php echo $argv[0]; ?> docs/structure.xml [output_dir]

Options:

    --lt [template]
        This specifies the 'template' for links we're generating. By default,
        this is "%c.md".
