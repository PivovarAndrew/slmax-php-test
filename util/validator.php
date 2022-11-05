<?php

/**
 * Author: Andrew Pivovar
 *
 * Implementation date: 04.11.2022 22:12
 *
 * Date of change: 04.11.2022 22:12
 *
 * Content of the file is a validator class.
 */

/**
 * Validation utility.
 */
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
