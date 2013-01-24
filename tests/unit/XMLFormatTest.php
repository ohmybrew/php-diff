<?php

namespace Wally\PHPDiff;

use Wally\PHPDiff\Diff;
use Wally\PHPDiff\Format\XML;

class XMLFormatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     */
    function itShouldExecuteAndReturnInXMLFormat()
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

        $format = new XML($result);
        $format->execute();
        $result = $format->getResult();

        $expect =
<<<EOF
<?xml version="1.0" encoding="UTF-8" ?>
<data>
<line>one</line>
<line>two</line>
<delete>three</delete>
<insert>threes</insert>
<insert>six</insert>
</data>
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

        $format = new XML($result);
        $format->execute();
        $result = $format->getResult();

        $expect =
<<<EOF
<?xml version="1.0" encoding="UTF-8" ?>
<data>
<line>one</line>
<line>two</line>
<line>three</line>
</data>
EOF;

        $this->assertEquals($expect, $result);
    }

    /**
     * @test
     *
     */
    function itShouldReturnResultAsEmptyIfNoInputPassed()
    {
        $format = new XML([]);
        $format->execute();

        $expect =
<<<EOF
<?xml version="1.0" encoding="UTF-8" ?>
<data>
</data>
EOF;
        $this->assertEquals($expect, $format->getResult());
    }

    /**
     * @test
     *
     */
    function itShouldReturnFormatNameAsXML()
    {
        $format = new XML([]);
        $this->assertEquals('xml', $format->getFormatName());
    }

    /**
     * @test
     *
     */
    function itShouldReturnFormatMineAsText()
    {
        $format = new XML([]);
        $this->assertEquals('text/xml', $format->getFormatMime());
    }
}
