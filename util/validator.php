<?php
class Validator
{
    public static function onlyLetters($word)
    {
        return preg_match("/^\\pL+( \\pL+)*$/u", $word);
    }

    public static function zeroOrOne($number)
    {
        return in_array($number, array(0, 1));
    }
}
