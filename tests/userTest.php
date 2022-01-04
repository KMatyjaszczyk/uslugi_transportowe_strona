<?php
include_once '../classes/User.php';
include_once '../classes/UserRepository.php';
include_once '../classes/UserService.php';

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
$testUserById = $testUserRepository->getById(29);
var_dump($testUserById);
echo "<br><br>";

echo "TEST USER REPOSITORY - GET BY LOGIN<br>";
$testUserByLogin = $testUserRepository->getByLogin("user");
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

echo "TEST USER SERVICE - GET BY ID<br>";
$testUserById = $testUserService->getById(2);
var_dump($testUserById);
echo "<br><br>";

echo "TEST USER SERVICE - GET BY LOGIN<br>";
$testUserByLogin = $testUserService->getByLogin('admin');
var_dump($testUserByLogin);
echo "<br><br>";

// echo "TEST USER SERVICE - CREATE<br>";
// $userToBeCreated = new User(null, 'j.kowalskyy', 'kowalsky123', 'kowalsky@onet.pl', false, new DateTime('2021/12/29 00:00:00'));
// $createResult = $testUserService->create($userToBeCreated);
// var_dump($createResult);
// echo "<br><br>";