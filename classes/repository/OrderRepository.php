<?php
include_once __DIR__ . './DbConfiguration.php';
include_once '../classes/model/Order.php';
// TODO write class
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

        // For test purposes
        echo DbConfiguration::$DB_HOSTNAME . ', ' . DbConfiguration::$DB_USERNAME
            . ', ' . DbConfiguration::$DB_PASSWORD . ', ' . DbConfiguration::$DB_DATABASE
            . ', ' . DbConfiguration::$DB_PORT . '<br>';
        echo 'Connection to database succeeded<br>';
    }

    public function __destruct() {
        $this->connection->close();
    }

    public function getAll(): ?array {
        $statement = $this->connection->prepare(
            "SELECT `id`, `clientName`, `clientEmail`, `departureDate`, 
                `destination`, `journeyForm`, `vehicle`, `additionalServices`, 
                `status`, `creationDate`, `lastUpdateDate` 
            FROM `orders`");
        $statement->execute();
        $result = $statement->get_result();
        var_dump($result); // For test purposes
        if ($result->num_rows == 0) {
            echo "There is no orders...<br>";
            return null;
        } else {
            $orders = [];
            while ($orderRecord = $result->fetch_object()) {
                $order = new Order(
                    $orderRecord->id,
                    $orderRecord->clientName,
                    $orderRecord->clientEmail,
                    new DateTime($orderRecord->departureDate),
                    $orderRecord->destination,
                    $orderRecord->journeyForm,
                    $orderRecord->vehicle,
                    explode(";", $orderRecord->additionalServices),
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
            "SELECT `id`, `clientName`, `clientEmail`, `departureDate`, 
                `destination`, `journeyForm`, `vehicle`, `additionalServices`, 
                `status`, `creationDate`, `lastUpdateDate` 
            FROM `orders` 
            WHERE `id` = ?");
        $statement->bind_param("i", $orderId);
        $statement->execute();
        $result = $statement->get_result();
        $orderFromResult = $result->fetch_object();
        var_dump($orderFromResult); // For test purposes
        if ($orderFromResult === null) {
            return null;
        } else {
            return new Order(
                $orderFromResult->id,
                $orderFromResult->clientName,
                $orderFromResult->clientEmail,
                new DateTime($orderFromResult->departureDate),
                $orderFromResult->destination,
                $orderFromResult->journeyForm,
                $orderFromResult->vehicle,
                explode(";", $orderFromResult->additionalServices),
                $orderFromResult->status,
                new DateTime($orderFromResult->creationDate),
                new DateTime($orderFromResult->lastUpdateDate),
            );
        }
    }

    public function create(Order $order): bool {
        $currentDate = new DateTime();
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
            (`clientName`, `clientEmail`, `departureDate`, `destination`, `journeyForm`, 
                `vehicle`, `additionalServices`, `status`, `creationDate`, `lastUpdateDate`)
            VALUES
            (?, ?, ?, ?, ?, ?, NULLIF(?, ''), ?, ?, ?)"
        );
        $statement->bind_param("sssssssiss",
            $preparedClientName, $preparedClientEmail, $preparedDepartureDate, $preparedDestination, 
            $preparedJourneyForm, $preparedVehicle, $preparedAdditionalServices, $preparedStatus, 
            $preparedCreationDate, $preparedLastUpdatedDate);

        if (!$statement->execute()) {
            echo "Failure on saving created order to database... <br>";
            return false;
        } else {
            //echo "Order created successfully!<br>"; // For test purposes
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
            echo "Order updated successfully!<br>"; // For test purposes
            return true;
        }
    }

    //TODO - add status to Order, add getByClientNameOrDestination
}