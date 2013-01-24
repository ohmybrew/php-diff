<?php

namespace Wally\PHPDiff;

use Wally\PHPDiff\Diff;

class BaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     *
     */
    function itShouldExplodeStringOne()
    {
        $diff = new Diff;
        $diff->setStringOne(
<<<EOF
One
Two
Three
EOF
);

        $this->assertEquals(["One", "Two", "Three"], $diff->getStringOne());
    }

    /**
     * @test
     *
     */
    function itShouldExplodeStringTwo()
    {
        $diff = new Diff;
        $diff->setStringTwo(
<<<EOF
One
Two
Three
EOF
);

        $this->assertEquals(["One", "Two", "Three"], $diff->getStringTwo());
    }

    /**
     * @test
     *
     */
    function itShouldReturnEMptyArrayForNoExecution()
    {
        $diff = new Diff;

        $this->assertEquals([], $diff->getResult());
    }

    /**
     * @test
     *
     */
    function itShouldReturnTheLineWithoutDeleteOrInsertSign()
    {
        $diff = new Diff;
        $diff->setStringOne('abcdefghi');
        $diff->setStringTwo('abcdefghi');
        $diff->execute();

        $result = $diff->getResult();

        $this->assertEquals([['l' => 'abcdefghi']], $result);
    }

    /**
     * @test
     *
     */
    function itShouldDiffSimple()
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

        $expect = [
                    [
                        'l' => 'one'
                    ],
                    [
                        'l' => 'two'
                    ],
                    [
                        '-' => 'three'
                    ],
                    [
                        '+' => 'threes'
                    ],
                    [
                        '+' => 'six'
                    ]
                ];
        $this->assertEquals($expect, $result);
    }
}
