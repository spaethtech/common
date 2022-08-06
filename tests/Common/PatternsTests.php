<?php
declare(strict_types=1);

namespace MVQN\Common;

use PHPUnit\Framework\TestCase;

final class PatternsTests extends TestCase
{



    public function testIsArrayFromAssociativeArrayString()
    {
        $valid      = "[ 'key' => 'value' ]";
        $test       = Patterns::isArray($valid);
        $this       ->assertTrue($test);

        var_dump($valid);

        $invalid    = "{ 'key': 'value' }";
        $test       = Patterns::isArray($invalid);
        $this       ->assertFalse($test);

        $invalid    = "'string'";
        $test       = Patterns::isArray($invalid);
        $this       ->assertFalse($test);


    }



}