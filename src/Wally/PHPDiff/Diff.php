<?php

namespace Wally\PHPDiff;

/**
 * This class provides a simple diff function.
 * 
 * Refactored for personal scope on base written by Dave Marshall
 *
 * @package Wally
 * @author  Walter Dal Mut
 * @author  (Forked tyler-king/php-diff) Tyler King <tyler.king@newfie.co>
 */
class Diff
{
    protected $string_1,
              $string_2,
              $result;

    public function __construct()
    {
        $this->result = [];

        return $this;
    }

    public function setStringOne($string)
    {
        $this->string_1 = explode("\n", $string);

        return $this;
    }

    public function getStringOne($as_text = false)
    {
        return ($as_text) ? implode("\n", $this->string_1) : $this->string_1;
    }

    public function setStringTwo($string)
    {
        $this->string_2 = explode("\n", $string);

        return $this;
    }

    public function getStringTwo($as_text = false)
    {
        return ($as_text) ? implode("\n", $this->string_2) : $this->string_2;
    }

    public function execute()
    {
        $this->_diff(
            $this->_lsm(),
            $this->string_1,
            $this->string_2,
            count($this->string_1) - 1,
            count($this->string_2) - 1
       );

        return $this;
    }

    public function getResult()
    {
        return $this->result;
    }

    protected function _lsm()
    {
        $mStart = 0;
        $mEnd   = count($this->string_1) - 1;

        $nStart = 0;
        $nEnd   = count($this->string_2) - 1;

        $c = [];
        for ($i = -1; $i <= $mEnd; $i++) {
            $c[$i] = [];
            for ($j = -1; $j <= $nEnd; $j++) {
                $c[$i][$j] = 0;
            }
        }

        for ($i = $mStart; $i <= $mEnd; $i++) {
            for ($j = $nStart; $j <= $nEnd; $j++) {
                if ($this->string_1[$i] == $this->string_2[$j]) {
                    $c[$i][$j] = $c[$i - 1][$j - 1] + 1;
                } else {
                    $c[$i][$j] = max($c[$i][$j - 1], $c[$i - 1][$j]);
                }
            }
        }

        return $c;
    }
 
    protected function _diff($c, $s1, $s2, $i, $j)
    {
        if ($i >= 0 && $j >= 0 && $s1[$i] == $s2[$j]) {
            $this->result   = array_merge($this->result, $this->_diff($c, $s1, $s2, $i - 1, $j - 1));
            $this->result[] = ['l' => $s1[$i]];
        } else {
            if ($j >= 0 && ($i == -1 || $c[$i][$j - 1] >= $c[$i - 1][$j])) {
                $this->result   = array_merge($this->result, $this->_diff($c, $s1, $s2, $i, $j - 1));
                $this->result[] = ['+' => $s2[$j]];
            } else if ($i >= 0 && ($j == -1 || $c[$i][$j - 1] < $c[$i - 1][$j])) {
                $this->result   = array_merge($this->result, $this->_diff($c, $s1, $s2, $i - 1, $j));
                $this->result[] = ['-' => $s1[$i]];
            }
        }

        return $this->result;
    }
}