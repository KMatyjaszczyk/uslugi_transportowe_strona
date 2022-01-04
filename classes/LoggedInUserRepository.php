<?php
include_once 'DbConfiguration.php';
include_once 'LoggedInUser.php';

class LoggedInUserRepository {
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

    public function getBySessionId(string $sessionId): ?LoggedInUser {
        $statement = $this->connection->prepare(
            "SELECT `sessionId`, `userId`, `lastUpdateDate` 
            FROM `logged_in_users` 
            WHERE `sessionId` = ?");
        $statement->bind_param("s", $sessionId);
        $statement->execute();
        $result = $statement->get_result();
        $loggedInUserFromResult = $result->fetch_object();
        // var_dump($loggedInUserFromResult); // For test purposes
        if ($loggedInUserFromResult === null) {
            return null;
        } else {
            return new LoggedInUser(
                $loggedInUserFromResult->sessionId,
                $loggedInUserFromResult->userId,
                new DateTime($loggedInUserFromResult->lastUpdateDate)
            );
        }
    }

    public function getByUserId(string $userId): ?array {
        $statement = $this->connection->prepare(
            "SELECT `sessionId`, `userId`, `lastUpdateDate` 
            FROM `logged_in_users` 
            WHERE `userId` = ?");
        $statement->bind_param("s", $userId);
        $statement->execute();
        $result = $statement->get_result();
        // var_dump($result); // For test purposes
        if ($result->num_rows == 0) {
            echo "There is no records for user with ID: $userId<br>";
            return null;
        } else {
            $loggedInUsers = [];
            while ($loggedInUserRecord = $result->fetch_object()) {
                $loggedInUser = new LoggedInUser(
                    $loggedInUserRecord->sessionId,
                    $loggedInUserRecord->userId,
                    new DateTime($loggedInUserRecord->lastUpdateDate)
                );
                array_push($loggedInUsers, $loggedInUser);
            }
            return $loggedInUsers;
        }
    }

    public function create(LoggedInUser $loggedInUser): bool {
        $preparedSessionId = $loggedInUser->getSessionId();
        $preparedUserId = $loggedInUser->getUserId();
        $preparedLastUdateDate = $loggedInUser->getLastUdateDate()->format('Y-m-d H:i:s');

        $statement = $this->connection->prepare(
            "INSERT INTO `logged_in_users` 
            (`sessionId`, `userId`, lastUpdateDate) 
            VALUES 
            (?, ?, ?)"
        );
        $statement->bind_param("sis", $preparedSessionId, $preparedUserId, $preparedLastUdateDate);

        if (!$statement->execute()) {
            echo "Failure on saving logged in user to database<br>";
            return false;
        } else {
            // echo "User created successfully!<br>"; // For test purposes
            return true;
        }
    }

    public function deleteBySessionId(string $sessionId): bool {
        $statement = $this->connection->prepare(
            "DELETE FROM `logged_in_users` WHERE `sessionId` = ?"
        );
        $statement->bind_param("s", $sessionId);
        
        if (!$statement->execute()) {
            echo "Deleting logged in user by session ID failed... <br>";
            return false;
        } else {
            echo "Deleting logged in user by session ID ended successfully! <br>"; // For test purposes
            return true;
        }
    }

    public function deleteByUserId(int $userId): bool {
        $statement = $this->connection->prepare(
            "DELETE FROM `logged_in_users` WHERE `userId` = ?"
        );
        $statement->bind_param("i", $userId);
        
        if (!$statement->execute()) {
            echo "Deleting logged in user by user ID failed... <br>";
            return false;
        } else {
            echo "Deleting logged in user by user ID ended successfully! <br>"; // For test purposes
            return true;
        }
    }
}