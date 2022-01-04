<?php
include_once 'classes/UserManager.php';

$userManager = new UserManager();

if (!isset($_GET['process'])) {
    header('Location: index.php');
} else {
    if ($_GET['process'] === 'login') {
        $loginResult = $userManager->login();
        if ($loginResult === null) {
            header('Location: login.php?loginResult=fail');
        } else {
            header('Location: index.php?loginResult=success');
        }
    } else if ($_GET['process'] === 'logout') {
        $sessionId = $userManager->retrieveSessionId();
        $logoutResult = $userManager->logout($sessionId);
        if ($logoutResult === true) {
            header('Location: index.php?logoutResult=success');
        } else {
            header('Location: index.php?logoutResult=fail');
        }
    }
}