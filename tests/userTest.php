<?php
include_once '../classes/model/User.php';
include_once '../classes/repository/UserRepository.php';
include_once '../classes/service/UserService.php';

echo "TEST USER<br>";
$testUser = new User(1, 'admin', 'admin', 'admin@admin.pl', true, new DateTime());
var_dump($testUser);
echo "<br><br>";

echo "<hr><br><br>";

echo "TEST OPEN USER REPOSITORY<br>";
$testUserRepository = new UserRepository();
var_dump($testUserRepository);
echo "<br><br>";

echo "TEST USER REPOSITORY - GET BY ID<br>";
$testUserById = $testUserRepository->getById(1);
var_dump($testUserById);
echo "<br><br>";

echo "TEST USER REPOSITORY - GET BY LOGIN<br>";
$testUserByLogin = $testUserRepository->getByLogin("admin");
var_dump($testUserByLogin);
echo "<br><br>";

// echo "TEST USER REPOSITORY - CREATE<br>";
// $userToBeCreated = new User(null, 'j.kowalskyy', 'kowalsky123', 'kowalsky@onet.pl', false, new DateTime('2021/12/29 00:00:00'));
// $createResult = $testUserRepository->create($userToBeCreated);
// var_dump($createResult);
// echo "<br><br>";

echo "<hr><br><br>";

echo "TEST CREATE USER SERVICE<br>";
$testUserService = new UserService;
var_dump($testUserService);
echo "<br><br>";