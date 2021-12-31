<?php
include_once __DIR__ . './DbConfiguration.php';
include_once '../classes/model/User.php';

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

        // For test purposes
        // echo DbConfiguration::$DB_HOSTNAME . ', ' . DbConfiguration::$DB_USERNAME
        //     . ', ' . DbConfiguration::$DB_PASSWORD . ', ' . DbConfiguration::$DB_DATABASE
        //     . ', ' . DbConfiguration::$DB_PORT . '<br>';
        // echo 'Connection to database succeeded<br>';
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
        // var_dump($userFromResult); // For test purposes

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

    public function getByLogin(string $login): ?User {
        $statement = $this->connection->prepare(
            "SELECT `id`, `login`, `password`, `email`, `isAdmin`, `creationDate` 
            FROM `users` 
            WHERE `login` = ?");
        $statement->bind_param("s", $login);
        $statement->execute();
        $result = $statement->get_result();
        $userFromResult = $result->fetch_object();
        // var_dump($userFromResult); // For test purposes

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

    public function create(User $user): bool {
        $preparedLogin = $user->getLogin();
        $preparedPassword = $user->getPassword();
        $preparedEmail = $user->getEmail();
        $preparedIsAdmin = $user->getIsAdmin();
        $preparedCreationDate = $user->getCreationDate()->format('Y-m-d H:i:s');

        $statement = $this->connection->prepare(
            "INSERT INTO `users`
            (`login`, `password`, `email`, `isAdmin`, `creationDate`)
            VALUES
            (?, ?, ?, ?, ?)"
        );
        $statement->bind_param("sssis", $preparedLogin, $preparedPassword, $preparedEmail, $preparedIsAdmin, $preparedCreationDate);
        
        if (!$statement->execute()) {
            echo "Failure on saving user to database<br>";
            return false;
        } else {
            echo "User created successfully!<br>"; // For test purposes
            return true;
        }
    }

}