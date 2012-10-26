<?php

namespace Wally\Format;

interface FormatInterface
{
    public function __construct( $input );
    public function getResult( );
    public function getFormatName( );
    public function getFormatMime( );
}