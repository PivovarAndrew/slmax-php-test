<?php

require_once 'core/db.php';
require_once 'util/validator.php';

class User
{
    private $db;

    private $id;
    private $name;
    private $surname;
    private $date_of_birthday;
    private $sex;
    private $city_of_birth;

    public function __construct($args)
    {
        $this->db = DB::getInstance();

        $this->setId($args['id']);

        if (count($args) > 1) {
            $this->setName($args['name']);
            $this->setSurname($args['surname']);
            $this->setDateOfBirthday($args['date_of_birthday']);
            $this->setSex($args['sex']);
            $this->setCityOfBirth($args['city_of_birth']);
        } else {
            $data = $this->find($this->getId());
            $this->setName($data['name']);
            $this->setSurname($data['surname']);
            $this->setDateOfBirthday($data['date_of_birthday']);
            $this->setSex($data['sex']);
            $this->setCityOfBirth($data['city_of_birth']);
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function getDateOfBirthday()
    {
        return $this->date_of_birthday;
    }

    public function getSex()
    {
        return $this->sex;
    }

    public function getCityOfBirth()
    {
        return $this->city_of_birth;
    }

    public function setId($id)
    {
        if (is_int($id)) {
            $this->id = $id;
        } else {
            throw new Exception("Id is required field");
        }
    }

    public function setName($name)
    {
        if (Validator::onlyLetters($name)) {
            $this->name = $name;
        } else {
            throw new Exception("Name must containt only letters");
        }
    }

    public function setSurname($surname)
    {
        if (Validator::onlyLetters($surname)) {
            $this->surname = $surname;
        } else {
            throw new Exception("Surname must contain only letters");
        }
    }

    public function setDateOfBirthday($date_of_birthday)
    {
        if ($date_of_birthday) {
            $this->date_of_birthday = $date_of_birthday;
        } else {
            throw new Exception("Date of birthday is required field");
        }
    }

    public function setSex($sex)
    {
        if (is_int($sex) && Validator::zeroOrOne($sex)) {
            $this->sex = $sex;
        } else {
            throw new Exception("Sex can be only 0 or 1");
        }
    }

    public function setCityOfBirth($city_of_birth)
    {
        if ($city_of_birth) {
            $this->city_of_birth = $city_of_birth;
        } else {
            throw new Exception("City of birth is required field");
        }
    }

    public function save()
    {
        $sql = "INSERT INTO users (id, name, surname, date_of_birthday, sex, city_of_birth) "
            . "values (:id, :name, :surname, :date_of_birthday, :sex, :city_of_birth)";
        $this->db->mutation($sql, $this->toArray());
        echo "{$this->getName()} is saved!\n";
    }

    public function delete($id)
    {
        $sql = "DELETE FROM users WHERE id = ?";
        $this->db->mutation($sql, array($id));
        echo "{$this->getName()} is deleted.\n";
    }

    public function find($id)
    {
        $sql = "SELECT name, surname, date_of_birthday, sex, city_of_birth FROM users WHERE id = :id";
        return $this->db->query($sql, ['id' => $id])[0];
    }

    public static function getAge($date_of_birthday)
    {
        return date_diff(date_create($date_of_birthday), date_create('today'))->y;
    }

    public static function sexToString($sex)
    {
        return $sex ? "male" : "female";
    }

    public function format($type) {
       switch ($type) {
        case "age":
            $this->setDateOfBirthday($this->getAge($this->getDateOfBirthday()));
        case 'gender':
            $this->sex = $this->sexToString($this->getSex());
       }

       return (object)(array)$this;
    }

    public function toArray()
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "surname" => $this->getSurname(),
            "date_of_birthday" => $this->getDateOfBirthday(),
            "sex" => $this->getSex(),
            "city_of_birth" => $this->getCityOfBirth()
        ];
    }
}
