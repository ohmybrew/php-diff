<?php namespace Wally\PHPDiff\Format;

interface FormatInterface
{
    public function __construct(array $input);
    public function getResult();
    public function getFormatName();
    public function getFormatMime();
}