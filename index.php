<?php

/**
 * Author: Andrew Pivovar
 *
 * Implementation date: 04.11.2022 16:05
 *
 * Date of change: 04.11.2022 23:50
 *
 * Index page displaying the functionality of the test task.
 */

require 'model/user.php';
require 'model/user_list.php';

header('Content-Type: application/json');

try {
    $user = new User(array(
          'id' => 1255,
          'name' => "Oleg",
          'surname' => "Barnaul",
          'date_of_birthday' => "2000-10-10",
          'sex' => 1,
          'city_of_birth' => "Minsk"
    ));
    print_r($user->toArray());
    $user->save();
    $user->delete(1255);
    print_r("{$user->getName()}'s age - " . User::getAge($user->getDateOfBirthday()) . "\n");
    print_r("{$user->getName()}'s gender - " . User::sexToString($user->getSex()) . "\n");
    $user->save();
    $user = new User(array('id' => 1255));
    print_r($user->toArray());
    print_r($user->format("age"));
    print_r($user->format("gender"));
    $user->delete(1255);
} catch (Exception $e) {
    echo '[Exception] ' . $e->getMessage();
}
