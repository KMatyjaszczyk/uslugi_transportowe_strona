<?php
include_once '../classes/model/LoggedInUser.php';

echo "TEST LOGGED IN USER<br>";
$testLoggedInUser = new LoggedInUser('abc123', 1, new DateTime('2021/12/29 00:00:00'));
var_dump($testLoggedInUser);
echo "<br><br>";