<?php
include_once '../classes/model/User.php';
include_once '../classes/repository/UserRepository.php';

echo "TEST USER<br>";
$testUser = new User(1, 'admin', 'admin', 'admin@admin.pl', true, new DateTime());
var_dump($testUser);
echo "<br><br>";

echo "TEST OPEN USER REPOSITORY<br>";
$testUserRepository = new UserRepository();
var_dump($testUserRepository);
echo "<br><br>";

echo "TEST USER REPOSITORY - GET BY ID<br>";
$testUser = $testUserRepository->getById(1);
echo "<br><br>";

echo "TEST USER REPOSITORY - CREATE<br>";
$userToBeCreated = new User(null, 'j.kowalskyy', 'kowalsky123', 'kowalsky@onet.pl', false, new DateTime('2021/12/29 00:00:00'));
$createResult = $testUserRepository->create($userToBeCreated);
var_dump($createResult);