<?php

require_once 'core/db.php';
require_once 'model/user.php';

if (class_exists('User')) {
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
