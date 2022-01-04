<?php
include_once '../classes/util/UserManager.php';
include_once '../classes/service/UserService.php';

echo "test POST array: <br>";
foreach ($_POST as $postKey => $postValue) {
    echo "$postKey => $postValue<br>";
}
echo "<br>";

$userManager = new UserManager();
$userId = $userManager->login();
if ($userId === null) {
    echo "Login failed...<br><br>";
} else {
    echo "Login successfull! ";
    echo "Session ID: " . session_id() . "<br>";
}

$userService = new UserService();
$user = $userService->getById($userId);
var_dump($user);

echo '<a href="userManagerLogoutTest.php">Wyloguj</a>';