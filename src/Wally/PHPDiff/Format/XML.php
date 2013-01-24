<?php

namespace Wally\PHPDiff\Format;

use Wally\PHPDiff\Format\FormatInterface;

class XML implements FormatInterface
{
    private $input,
            $result;

    public function __construct(array $input)
    {
        $this->input   = $input;
        $this->result  = '';

        return $this;
    }

    public function execute()
    {
        $result = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n<data>\n";
        foreach ($this->input as $key => $value) {
            $k = key($value);
            $v = $value[$k];

            switch ($k) {
                case '-':
                    $result .= "<delete>{$v}</delete>\n";
                    break;
                case '+':
                    $result .= "<insert>{$v}</insert>\n";
                    break;
                case 'l':
                    $result .= "<line>{$v}</line>\n";
                    break;
            }
        }

        $this->result = $result . "</data>";

        return $this;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function getFormatName()
    {
        return 'xml';
    }

    public function getFormatMime()
    {
        return 'text/xml';
    }
}