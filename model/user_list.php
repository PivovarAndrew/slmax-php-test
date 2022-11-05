<?php

/**
 * Author: Andrew Pivovar
 *
 * Implementation date: 04.11.2022 22:30
 *
 * Date of change: 06.11.2022 01:20
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
        private $users;

        public function __construct($user_ids) {
            $this->db = DB::getInstance();

            $this->setUserIds($user_ids);
        }

        public function getUserIds() {
            return $this->user_ids;
        }

        public function setUserIds($user_ids) {
            array_unshift($user_ids,"");
            unset($user_ids[0]);

            $this->user_ids = $user_ids;
            $this->setUsers();
        }

        public function getUsers() {
            return $this->users;
        }

        public function deleteUser($user) {
            $user->delete($user->getId());
        }

        public function toArray() {
            $users = [];

            foreach($this->getUsers() as $key => $user) {
                $users[] = $user->toArray();
            }

            return $users;
        }

        private function setUsers() {
            foreach($this->findUsers() as $key => $user) {
                $this->users[$key] = new User(array(
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'surname' => $user['surname'],
                    'date_of_birthday' => $user['date_of_birthday'],
                    'sex' => $user['sex'],
                    'city_of_birth' => $user['city_of_birth']         
                ));
            }
        }

        private function findUsers() {
            $prepare_params = rtrim(str_repeat('?,', count($this->getUserIds())), ',');
            $sql = "SELECT * FROM users WHERE id IN({$prepare_params})";
            return $this->db->query($sql, $this->getUserIds());
        }
    }
} else {
    throw new Exception("Class User doesn't exist. Program execution is not possible.");
}
