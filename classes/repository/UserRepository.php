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
}