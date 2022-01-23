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

if (!$isUserLoggedIn || $user->getIsAdmin() == true) {
    header('Location: index.php?status=processReservationForbidden');
}

$validationArguments = [
    'clientName' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'clientEmail' => FILTER_VALIDATE_EMAIL,
    'departureDateDate' => [
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => ['regexp' => '/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/']
    ],
    'departureDateTime' => [
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => ['regexp' => '/^[0-9]{2}:[0-9]{2}$/']
    ],
    'destination' => [
        'filter' => FILTER_VALIDATE_REGEXP,
        'options' => ['regexp' => 
            '/^[A-ZĄĆĘŁŃÓŚŹŻa-ząćęłńóśźż][A-ZĄĆĘŁŃÓŚŹŻa-ząćęłńóśźż \.\-]{2,}$/']
    ],
    'journeyForm' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'vehicle' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
];

$additionalServices = null;
if ($_POST['additionalServices'] === null) {
    $additionalServices = [];
} else {
    $additionalServices = $_POST['additionalServices'];
}

$filteredData = filter_input_array(INPUT_POST, $validationArguments);
$errors = "";
foreach ($filteredData as $key => $value) {
    if ($value === false or $value === null) {
        $errors .= $key . " ";
    }
}

if ($errors !== "") {
    header('Location: rezerwacja.php?reservationResult=fail');
}

$departureDate = $filteredData['departureDateDate'] . 
    ' ' . $filteredData['departureDateTime'];
$order = new Order(
    null,
    $user->getId(),
    $filteredData['clientName'],
    $filteredData['clientEmail'],
    new DateTime($departureDate),
    $filteredData['destination'],
    $filteredData['journeyForm'],
    $filteredData['vehicle'],
    $additionalServices,
    Order::$STATUS_CREATED,
    null,
    null
);

if ($order->getDepartureDate() < new DateTime()) {
    header('Location: rezerwacja.php?reservationResult=fail');
    die();
}

$orderCreateresult = $orderService->create($order);
header('Location: rezerwacja.php?reservationResult=success');