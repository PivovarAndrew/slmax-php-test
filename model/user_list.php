<?php
/**
 * Author: Andrew Pivovar
 *
 * Implementation date: 04.11.2022 22:30
 *
 * Date of change: 04.11.2022 23:50
 *
 * Content of the file is a user list class.
 */

require_once 'core/db.php';
require_once 'model/user.php';

if (class_exists('User')) {

    /**
     * Representing the users table as a user list entity.
     */
    class UserList
    {    
        private $db;

        private $user_ids;

        public function __construct($user_ids) {
            $this->db = DB::getInstance();

            $this->user_ids = $user_ids;
        }

        public function getUserIds() {
            return $this->user_ids;
        }
    }
} else {
    throw new Exception("Class User doesn't exist. Program execution is not possible.");
}
