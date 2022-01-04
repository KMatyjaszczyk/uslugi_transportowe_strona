<?php
include_once 'classes/util/UserManager.php';

$userManager = new UserManager();

if (!isset($_GET['process'])) {
    header('Location: index.php');
} else {
    if ($_GET['process'] === 'login') {
        $loginResult = $userManager->login();
        if ($loginResult === null) {
            header('Location: login.php?loginResult=fail');
        } else {
            header('Location: index.php');
        }
    }
}