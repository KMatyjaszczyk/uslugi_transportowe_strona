<?php
include_once __DIR__ . './DbConfiguration.php';
include_once 'classes/model/User.php';
// TODO write class
class UserRepository {
    protected mysqli $connection;

    public function __construct() {
        $this->connection = new mysqli(DbConfiguration::$DB_HOSTNAME,
            DbConfiguration::$DB_USERNAME, DbConfiguration::$DB_PASSWORD,
            DbConfiguration::$DB_DATABASE, DbConfiguration::$DB_PORT);

        if ($this->connection->connect_errno) {
            echo 'Connection with database failed<br>';
            exit();
        }
        if (!$this->connection->set_charset('utf8')) {
            echo 'Failed to change encryption type to UTF8<br>';
            exit();
        }

        // FOR TESTS
        echo DbConfiguration::$DB_HOSTNAME . ', ' . DbConfiguration::$DB_USERNAME
            . ', ' . DbConfiguration::$DB_PASSWORD . ', ' . DbConfiguration::$DB_DATABASE
            . ', ' . DbConfiguration::$DB_PORT . '<br>';
        echo 'Connection to database succeeded<br>';
    }

    public function __destruct() {
        $this->connection->close();
    }

    public function getById(int $id): ?User {
        $statement = $this->connection->prepare(
            "SELECT `id`, `login`, `password`, `email`, `isAdmin`, `creationDate` 
            FROM `users` 
            WHERE `id` = ?");
        $statement->bind_param("i", $id);
        $statement->execute();
        $result = $statement->get_result();
        $userFromResult = $result->fetch_object();
        var_dump($userFromResult);
        if ($userFromResult === null) {
            return null;
        } else {
            return new User(
                $userFromResult->id,
                $userFromResult->login,
                $userFromResult->password,
                $userFromResult->email,
                $userFromResult->isAdmin,
                new DateTime($userFromResult->creationDate)
            );
        }
    }

    

}