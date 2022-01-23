<?php
include_once 'DbConfiguration.php';
include_once 'Order.php';

class OrderRepository {
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
    }

    public function __destruct() {
        $this->connection->close();
    }

    public function getAll(): ?array {
        $statement = $this->connection->prepare(
            "SELECT `id`, `userId`, `clientName`, `clientEmail`, `departureDate`, 
                `destination`, `journeyForm`, `vehicle`, `additionalServices`, 
                `status`, `creationDate`, `lastUpdateDate` 
            FROM `orders`");
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows == 0) {
            return null;
        } else {
            $orders = [];
            while ($orderRecord = $result->fetch_object()) {
                $additionalServicesArray = [];
                if ($orderRecord->additionalServices !== null) {
                    $additionalServicesArray = explode(";", $orderRecord->additionalServices);
                }

                $order = new Order(
                    $orderRecord->id,
                    $orderRecord->userId,
                    $orderRecord->clientName,
                    $orderRecord->clientEmail,
                    new DateTime($orderRecord->departureDate),
                    $orderRecord->destination,
                    $orderRecord->journeyForm,
                    $orderRecord->vehicle,
                    $additionalServicesArray,
                    $orderRecord->status,
                    new DateTime($orderRecord->creationDate),
                    new DateTime($orderRecord->lastUpdateDate),
                );
                array_push($orders, $order);
            }
            return $orders;
        }
    }

    public function getById(int $orderId): ?Order {
        $statement = $this->connection->prepare(
            "SELECT `id`, `userId`, `clientName`, `clientEmail`, `departureDate`, 
                `destination`, `journeyForm`, `vehicle`, `additionalServices`, 
                `status`, `creationDate`, `lastUpdateDate` 
            FROM `orders` 
            WHERE `id` = ?");
        $statement->bind_param("i", $orderId);
        $statement->execute();
        $result = $statement->get_result();
        $orderFromResult = $result->fetch_object();

        if ($orderFromResult === null) {
            return null;
        } else {
            $additionalServicesArray = [];
            if ($orderFromResult->additionalServices !== null) {
                $additionalServicesArray = explode(";", $orderFromResult->additionalServices);
            }

            return new Order(
                $orderFromResult->id,
                $orderFromResult->userId,
                $orderFromResult->clientName,
                $orderFromResult->clientEmail,
                new DateTime($orderFromResult->departureDate),
                $orderFromResult->destination,
                $orderFromResult->journeyForm,
                $orderFromResult->vehicle,
                $additionalServicesArray,
                $orderFromResult->status,
                new DateTime($orderFromResult->creationDate),
                new DateTime($orderFromResult->lastUpdateDate),
            );
        }
    }

    public function getByUserId(int $userId): ?array {
        $statement = $this->connection->prepare(
            "SELECT `id`, `userId`, `clientName`, `clientEmail`, `departureDate`, 
                `destination`, `journeyForm`, `vehicle`, `additionalServices`, 
                `status`, `creationDate`, `lastUpdateDate` 
            FROM `orders` 
            WHERE `userId` = ?");
        $statement->bind_param("i", $userId);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows == 0) {
            return null;
        } else {
            $orders = [];
            while ($orderRecord = $result->fetch_object()) {
                $additionalServicesArray = [];
                if ($orderRecord->additionalServices !== null) {
                    $additionalServicesArray = explode(";", $orderRecord->additionalServices);
                }

                $order = new Order(
                    $orderRecord->id,
                    $orderRecord->userId,
                    $orderRecord->clientName,
                    $orderRecord->clientEmail,
                    new DateTime($orderRecord->departureDate),
                    $orderRecord->destination,
                    $orderRecord->journeyForm,
                    $orderRecord->vehicle,
                    $additionalServicesArray,
                    $orderRecord->status,
                    new DateTime($orderRecord->creationDate),
                    new DateTime($orderRecord->lastUpdateDate),
                );
                array_push($orders, $order);
            }
            return $orders;
        }
    }

    public function getByClientNameOrDestination(string $clientNameOrDestination): ?array {
        $preparedClientNameOrDestination = '%'.$clientNameOrDestination.'%';
        $statement = $this->connection->prepare(
            "SELECT `id`, `userId`, `clientName`, `clientEmail`, `departureDate`, `destination`,
                `journeyForm`, `vehicle`, `additionalServices`, `status`, `creationDate`,
                `lastUpdateDate`
            FROM `orders`
            WHERE `clientName` LIKE ? OR `destination` LIKE ?");
        $statement->bind_param("ss", $preparedClientNameOrDestination, $preparedClientNameOrDestination);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows == 0) {
            return null;
        } else {
            $orders = [];
            while ($orderRecord = $result->fetch_object()) {
                $additionalServicesArray = [];
                if ($orderRecord->additionalServices !== null) {
                    $additionalServicesArray = explode(";", $orderRecord->additionalServices);
                }

                $order = new Order(
                    $orderRecord->id,
                    $orderRecord->userId,
                    $orderRecord->clientName,
                    $orderRecord->clientEmail,
                    new DateTime($orderRecord->departureDate),
                    $orderRecord->destination,
                    $orderRecord->journeyForm,
                    $orderRecord->vehicle,
                    $additionalServicesArray,
                    $orderRecord->status,
                    new DateTime($orderRecord->creationDate),
                    new DateTime($orderRecord->lastUpdateDate),
                );
                array_push($orders, $order);
            }
            return $orders;
        }
    }

    public function create(Order $order): bool {
        $currentDate = new DateTime();
        $preparedUserId = $order->getUserId();
        $preparedClientName = $order->getClientName();
        $preparedClientEmail = $order->getClientEmail();
        $preparedDepartureDate = $order->getDepartureDate()->format('Y-m-d H:i:s');
        $preparedDestination = $order->getDestination();
        $preparedJourneyForm = $order->getJourneyForm();
        $preparedVehicle = $order->getVehicle();
        $preparedAdditionalServices = "";
        $preparedStatus = $order->getStatus();
        $preparedCreationDate = $currentDate->format('Y-m-d H:i:s');
        $preparedLastUpdatedDate = $currentDate->format('Y-m-d H:i:s');

        if (!empty($order->getAdditionalServices())) {
            $preparedAdditionalServices = implode(";", $order->getAdditionalServices());
        }

        $statement = $this->connection->prepare(
            "INSERT INTO `orders`
            (`userId`, `clientName`, `clientEmail`, `departureDate`, `destination`, `journeyForm`, 
                `vehicle`, `additionalServices`, `status`, `creationDate`, `lastUpdateDate`)
            VALUES
            (?, ?, ?, ?, ?, ?, ?, NULLIF(?, ''), ?, ?, ?)"
        );
        $statement->bind_param("isssssssiss",
            $preparedUserId, $preparedClientName, $preparedClientEmail, $preparedDepartureDate, 
            $preparedDestination, $preparedJourneyForm, $preparedVehicle, $preparedAdditionalServices, 
            $preparedStatus, $preparedCreationDate, $preparedLastUpdatedDate);

        if (!$statement->execute()) {
            echo "Failure on saving created order to database... <br>";
            return false;
        } else {
            return true;
        }
    }

    public function update(int $orderId, Order $orderToBeUpdated): bool {
        $currentDate = new DateTime();
        $preparedClientName = $orderToBeUpdated->getClientName();
        $preparedClientEmail = $orderToBeUpdated->getClientEmail();
        $preparedDepartureDate = $orderToBeUpdated->getDepartureDate()->format('Y-m-d H:i:s');
        $preparedDestination = $orderToBeUpdated->getDestination();
        $preparedJourneyForm = $orderToBeUpdated->getJourneyForm();
        $preparedVehicle = $orderToBeUpdated->getVehicle();
        $preparedAdditionalServices = "";
        $preparedLastUpdatedDate = $currentDate->format('Y-m-d H:i:s');

        if (!empty($orderToBeUpdated->getAdditionalServices())) {
            $preparedAdditionalServices = implode(";", $orderToBeUpdated->getAdditionalServices());
        }

        $statement = $this->connection->prepare(
            "UPDATE `orders` SET
                `clientName` = ?, 
                `clientEmail` = ?, 
                `departureDate` = ?, 
                `destination` = ?, 
                `journeyForm` = ?, 
                `vehicle` = ?, 
                `additionalServices` = NULLIF(?, ''), 
                `lastUpdateDate` = ?
            WHERE `id` = ?"
        );
        $statement->bind_param("ssssssssi",
            $preparedClientName, $preparedClientEmail, $preparedDepartureDate,
            $preparedDestination, $preparedJourneyForm, $preparedVehicle,
            $preparedAdditionalServices, $preparedLastUpdatedDate, $orderId);

        if (!$statement->execute()) {
            echo "Failure on updating order on database... <br>";
            return false;
        } else {
            return true;
        }
    }

    public function updateStatus(int $orderId, int $statusToBeUpdated): bool {
        $currentDate = new DateTime();
        $preparedStatus = $statusToBeUpdated;
        $preparedLastUpdatedDate = $currentDate->format('Y-m-d H:i:s');
        
        $statement = $this->connection->prepare(
            "UPDATE `orders` SET 
                `status` = ?, 
                `lastUpdateDate` = ? 
            WHERE `id` = ?"
        );
        $statement->bind_param("isi", $preparedStatus, $preparedLastUpdatedDate, $orderId);

        if (!$statement->execute()) {
            echo "Failure on updating order on database... <br>";
            return false;
        } else {
            return true;
        }
    }

    public function deleteById(int $orderId): bool {
        $statement = $this->connection->prepare(
            "DELETE FROM `orders` WHERE id = ?"
        );
        $statement->bind_param("i", $orderId);
        
        if (!$statement->execute()) {
            echo "Failure on deleting order from database with ID: $orderId... <br>";
            return false;
        } else {
            return true;
        }
    }
}