<?php
/**
 * Author: Andrew Pivovar
 *
 * Implementation date: 04.11.2022 17:15
 *
 * Date of change: 04.11.2022 17:15
 *
 * Content of the file is a database class.
 */

require_once 'config/db.php';

/**
 * Singleton class for connecting and processing requests to the database.
 */
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

    /**
     * Request method with optional parameter passing directed  to get database data.
     *
     * @param string          $sql
     * @param array | null    $data
     * @return array | void
     * @throws PDOException if request failed
     */
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

    /**
     * Request method with parameter passing directed to get database data.
     *
     * @param string    $sql
     * @param array     $data
     * @return void
     * @throws PDOException if request failed
     */
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
