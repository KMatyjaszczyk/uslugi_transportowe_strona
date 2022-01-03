<?php
include '../classes/util/UserManager.php';

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