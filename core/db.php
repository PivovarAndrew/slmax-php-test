<?php

require_once 'config/db.php';

class DB
{
    private $dbh;
    private static $instance;

    private function __construct()
    {
        try {
            $dsn = 'mysql:host=' . HOST_NAME
                . ';dbname='    . DB_NAME
                . ';port='      . PORT;
        } catch (PDOException $e) {
            echo "DB Exception: " . $e->getMessage();
        }

        $user = USER_NAME;
        $password = PASSWORD;
        $this->dbh = new PDO($dsn, $user, $password);
        $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            $object = __CLASS__;
            self::$instance = new $object;
        }
        
        return self::$instance;
    }

    public function query($sql, $data = null)
    {
        try {
            $stmt = $this->dbh->prepare($sql);

            if ($data) {
                foreach ($data as $key => &$val) {
                    $stmt->bindParam($key, $val);
                }
            }

            $stmt->execute();
            $response = [];

            while (($row = $stmt->fetch(PDO::FETCH_ASSOC)) !== false) {
                $response[] = $row;
            }

            return $response;
        } catch (PDOException $e) {
            echo "[DB Exception] " . $e->getMessage();
        }
    }

    public function mutation($sql, $data)
    {
        try {
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute($data);
        } catch (PDOException $e) {
            echo "[DB Exception] " . $e->getMessage();
        }
    }
}
