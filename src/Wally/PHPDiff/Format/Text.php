<?php namespace Wally\PHPDiff\Format;

use Wally\PHPDiff\Format\FormatInterface;

class Text implements FormatInterface
{
    private $input,
            $result;

    public function __construct(array $input)
    {
        $this->input = $input;
        $this->result = '';

        return $this;
    }

    public function execute()
    {
        $result = '';

        foreach ($this->input as $key => $value) {
            $k = key($value);
            $v = $value[$k];

            switch ($k) {
                case '-':
                    $result .= "- {$v}\n";
                    break;
                case '+':
                    $result .= "+ {$v}\n";
                    break;
                case 'l':
                    $result .= "{$v}\n";
                    break;
            }
        }

        $this->result = trim($result);

        return $this;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function getFormatName()
    {
        return 'text';
    }

    public function getFormatMime()
    {
        return 'text/plain';
    }
}