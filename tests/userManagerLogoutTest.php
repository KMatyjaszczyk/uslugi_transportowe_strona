<?php
include_once '../classes/util/UserManager.php';
include_once '../classes/service/LoggedInUserService.php';

session_start();

$sessionId = session_id();
echo "session ID: $sessionId<br>";

$userManager = new UserManager();
$logoutResult = $userManager->logout($sessionId);
if ($logoutResult == true) {
    echo "User logged out successfully!<br>";
} else {
    echo "Failed to logout user<br>";
}

echo '<a href="userManagerTest.php">Back</a>';