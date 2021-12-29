<?php
include_once '../classes/model/LoggedInUser.php';
include_once '../classes/repository/LoggedInUserRepository.php';

echo "TEST LOGGED IN USER<br>";
$testLoggedInUser = new LoggedInUser('abc123', 1, new DateTime('2021/12/29 00:00:00'));
var_dump($testLoggedInUser);
echo "<br><br>";

echo "TEST OPEN LOGGED IN USER REPOSITORY<br>";
$testLoggedInUserRepository = new LoggedInUserRepository();
var_dump($testLoggedInUserRepository);
echo "<br><br>";

echo "TEST LOGGED IN USER REPOSITORY - GET BY ID<br>";
$getBySessionId = $testLoggedInUserRepository->getBySessionId('abcd123');
var_dump($getBySessionId);
echo "<br><br>";

echo "TEST LOGGED IN USER REPOSITORY - GET BY USER ID<br>";
$getByUserId = $testLoggedInUserRepository->getByUserId(1);
var_dump($getByUserId);
echo "<br><br>";

echo "TEST LOGGED IN USER REPOSITORY - CREATE<br>";
$loggedInUserToBeCreated = new LoggedInUser('abcd124', 3, new DateTime('2021-12-29 00:00:00'));
$createResult = $testLoggedInUserRepository->create($loggedInUserToBeCreated);
var_dump($createResult);
echo "<br><br>";

echo "TEST LOGGED IN USER REPOSITORY - DELETE BY SESSION ID<br>";
$deleteBySessionIdResult = $testLoggedInUserRepository->deleteBySessionId('abcd124');
var_dump($deleteBySessionIdResult);
echo "<br><br>";

echo "TEST LOGGED IN USER REPOSITORY - DELETE BY USER ID<br>";
$deleteByUserIdResult = $testLoggedInUserRepository->deleteByUserId(1);
var_dump($deleteByUserIdResult);
echo "<br><br>";