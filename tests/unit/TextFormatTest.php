<?php

namespace Wally\PHPDiff;

use Wally\PHPDiff\Diff;
use Wally\PHPDiff\Format\Text;

class TextFormatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     */
    function itShouldExecuteAndReturnInTextFormat()
    {
        $diff = new Diff;
        $diff->setStringOne(
<<<EOF
one
two
three
EOF
        );
        $diff->setStringTwo(
<<<EOF
one
two
threes
six
EOF
        );
        $diff->execute();
        $result = $diff->getResult();

        $format = new Text($result);
        $format->execute();
        $result = $format->getResult();

        $expect =
<<<EOF
one
two
- three
+ threes
+ six
EOF;

        $this->assertEquals($expect, $result);
    }

    /**
     * @test
     *
     */
    function itShouldExecuteAndReturnInTextFormatWithoutDelOrInsert()
    {
        $diff = new Diff;
        $diff->setStringOne(
<<<EOF
one
two
three
EOF
        );
        $diff->setStringTwo(
<<<EOF
one
two
three
EOF
        );
        $diff->execute();
        $result = $diff->getResult();

        $format = new Text($result);
        $format->execute();
        $result = $format->getResult();

        $expect =
<<<EOF
one
two
three
EOF;

        $this->assertEquals($expect, $result);
    }

    /**
     * @test
     *
     */
    function itShouldReturnResultAsEmptyIfNoInputPassed()
    {
        $format = new Text([]);
        $format->execute();
        $this->assertEquals('', $format->getResult());
    }

    /**
     * @test
     *
     */
    function itShouldReturnFormatNameAsText()
    {
        $format = new Text([]);
        $this->assertEquals('text', $format->getFormatName());
    }

    /**
     * @test
     *
     */
    function itShouldReturnFormatMineAsText()
    {
        $format = new Text([]);
        $this->assertEquals('text/plain', $format->getFormatMime());
    }
}
