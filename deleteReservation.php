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
if (!$isUserLoggedIn || $user->getIsAdmin() === false) {
    header('Location: index.php?status=changeReservationStatusForbidden');
}

$validationArguments = [
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
    header('Location: panel_zamowien.php?deleteReservationResult=fail');
}

$orderId = $filteredData['orderId'];
$deleteResult = $orderService->deleteById($orderId);

if ($deleteResult === true) {
    header('Location: panel_zamowien.php?deleteReservationResult=success');
} else {
    header('Location: panel_zamowien.php?deleteReservationResult=fail');
}
