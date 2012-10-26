<?php
require_once __DIR__ . '/../src/Wally/Diff.php';
require_once __DIR__ . '/../src/Wally/Format/FormatInterface.php';
require_once __DIR__ . '/../src/Wally/Format/Text.php';
require_once __DIR__ . '/../src/Wally/Format/XML.php';
 
class BaseTest extends PHPUnit_Framework_TestCase
{
    public function testDiffBase( )
    {
        $n = @new \Wally\Diff;
        $n->setStringOne( 'abcdefghi' );
        $n->setStringTwo( 'abcdefghi' );
        $n->execute( );

        $diff = $n->getResult( );
        
        $expect = array(
                    array(
                        'l' => 'abcdefghi'
                    )
                );
        $this->assertEquals( $expect, $diff );
    }

    public function testDiffComplex( )
    {
        $n = @new \Wally\Diff;
        $n->setStringOne(
<<<EOF
one
two
three
EOF
        );
        $n->setStringTwo(
<<<EOF
one
two
threes
six
EOF
        );
        $n->execute( );

        $diff = $n->getResult( );

        $expect = array(
                    array(
                        'l' => 'one'
                    ),
                    array(
                        'l' => 'two'
                    ),
                    array(
                        '-' => 'three'
                    ),
                    array(
                        '+' => 'threes'
                    ),
                    array(
                        '+' => 'six'
                    )
                );
        
        $this->assertEquals( $expect, $diff );
    }

    public function testDiffComplexText( )
    {
        $n = @new \Wally\Diff;
        $n->setStringOne(
<<<EOF
one
two
three
EOF
        );
        $n->setStringTwo(
<<<EOF
one
two
threes
six
EOF
        );
        $n->execute( );

        $diff = $n->getResult( );

        $f      = @new \Wally\Format\Text( $diff );
        $f->execute( );
        $result = $f->getResult( );

        $expect = <<<EOF
one
two
- three
+ threes
+ six
EOF;
        $this->assertEquals( $expect, $result );
    }

    public function testDiffComplexXML( )
    {
        $n = @new \Wally\Diff;
        $n->setStringOne(
<<<EOF
one
two
three
EOF
        );
        $n->setStringTwo(
<<<EOF
one
two
threes
six
EOF
        );
        $n->execute( );

        $diff = $n->getResult( );

        $f      = @new \Wally\Format\XML( $diff );
        $f->execute( );
        $result = $f->getResult( );

        $expect = <<<EOF
<?xml version="1.0" encoding="UTF-8" ?>
<data>
<line>one</line>
<line>two</line>
<delete>three</delete>
<insert>threes</insert>
<insert>six</insert>
</data>
EOF;
        $this->assertEquals( $expect, $result );
    }
}