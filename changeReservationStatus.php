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
    die();
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
    die();
}

var_dump($filteredData);
var_dump($user->getId());

$orderId = $filteredData['orderId'];
$statusToBeChanged = $filteredData['status'];

$isStatusProper = false;
switch ($statusToBeChanged) {
    case Order::$STATUS_CANCELLED:
        $isStatusProper = true;
        break;
    case Order::$STATUS_ACCEPTED:
        $isStatusProper = true;
        break;
    case Order::$STATUS_REALISED:
        $isStatusProper = true;
        break;
    default:
        $isStatusProper = false;
        break;
}

if ($isStatusProper === false) {
    header('Location: index.php?changeReservationStatusResult=illegalStatus');
    die();
}

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
    die();
}

echo 'status to be changed: ' . $statusToBeChanged . '<br>';
echo 'order->getStatus(): ' . $order->getStatus() . '<br>';

if ($user->getIsAdmin() === false) { // standard user processing
    if ($statusToBeChanged === Order::$STATUS_CANCELLED) {
        // check if user changes his own order
        if ($order->getUserId() !==  $user->getId()) {
            header('Location: twoje_rezerwacje.php?changeReservationStatusResult=notYourReservation');
            die();
        }
    
        // check if order was already cancelled or finished
        if ($order->getStatus() === Order::$STATUS_CANCELLED || $order->getStatus() === Order::$STATUS_REALISED) {
            header('Location: twoje_rezerwacje.php?changeReservationStatusResult=alreadyCancelledOrRealised');
            die();
        } else {
            $statusUpdateResult = $orderService->updateStatus($orderId, $statusToBeChanged);
            if ($statusUpdateResult === true) {
                header('Location: twoje_rezerwacje.php?changeReservationStatusResult=success');
                die();
            } else {
                header('Location: twoje_rezerwacje.php?changeReservationStatusResult=fail');
                die();
            }
        }
    }
} else { // admin processing
    $statusUpdateResult = $orderService->updateStatus($orderId,  $statusToBeChanged);
    if ($statusUpdateResult === true) {
        header('Location: panel_zamowien.php?changeReservationStatusResult=success');
        die();
    } else {
        header('Location: panel_zamowien.php?changeReservationStatusResult=fail');
        die();
    }
}
