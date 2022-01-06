<?php
include_once 'classes/LoggedInUserService.php';
include_once 'classes/UserService.php';
include_once 'classes/UserManager.php';
include_once 'classes/OrderService.php';
include_once 'classes/Order.php';

$loggedInUserService = new LoggedInUserService();
$userService = new UserService();
$userManager = new UserManager();
$orderService = new OrderService();

$sessionId = $userManager->retrieveSessionId();
$isUserLoggedIn = $userManager->isUserLoggedIn($sessionId);
$user = null;
if ($isUserLoggedIn) {
    $user = $userService->getById(
        $loggedInUserService->getBySessionId($sessionId)->getUserId()
    );
}
if (!$isUserLoggedIn) {
    header('Location: index.php?status=changeReservationStatusForbidden');
}

$validationArguments = [
    'status' => FILTER_VALIDATE_INT,
    'orderId' => FILTER_VALIDATE_INT
];
$filteredData = filter_input_array(INPUT_GET, $validationArguments);
$errors = "";
foreach ($filteredData as $key => $value) {
    if ($value === false or $value === null) {
        $errors .= $key . " ";
    }
}
if ($errors !== "") {
    header('Location: index.php?changeReservationStatusResult=fail');
}

var_dump($filteredData);
var_dump($user->getId());

$orderId = $filteredData['orderId'];
$statusToBeChanged = $filteredData['status'];

// get order by ID
$order = $orderService->getById($orderId);
echo '<br><br>';
echo 'order: ';
var_dump($order);
echo '<br><br>';
echo 'user: ';
var_dump($user);

//  check if order exists
if ($order === null) {
    header('Location: index.php?changeReservationStatusResult=fail');
}

echo 'status to be changed: ' . $statusToBeChanged . '<br>';
echo 'order->getStatus(): ' . $order->getStatus() . '<br>';

if ($user->getIsAdmin() === false) { // standard user processing
    if ($statusToBeChanged === Order::$STATUS_CANCELLED) {
        // check if user changes his own order
        if ($order->getUserId() !==  $user->getId()) {
            header('Location: twoje_rezerwacje.php?changeReservationStatusResult=notYourReservation');
        }
    
        // check if order was already cancelled or finished
        if ($order->getStatus() === Order::$STATUS_CANCELLED || $order->getStatus() === Order::$STATUS_REALISED) {
            header('Location: twoje_rezerwacje.php?changeReservationStatusResult=alreadyCancelledOrRealised');
        } else {
            $statusUpdateResult = $orderService->updateStatus($orderId, $statusToBeChanged);
            if ($statusUpdateResult === true) {
                header('Location: twoje_rezerwacje.php?changeReservationStatusResult=success');
            } else {
                header('Location: twoje_rezerwacje.php?changeReservationStatusResult=fail');
            }
        }
    }
} else { // admin processing
    // TODO: implement
}
