<?php
include_once './classes/model/User.php';
include_once './classes/model/Order.php';
include_once './classes/model/LoggedInUser.php';

echo "TEST USER<br>";
$testUser = new User(1, 'admin', 'admin', 'admin@admin.pl', true);
var_dump($testUser);
echo "<br><br>";

echo "TEST ORDER<br>";
$testOrder = new Order(1, 'Jan Kowalski Sp. z o.o.', 'jan.kowalski@gmail.com', 
    new DateTime('2022/01/12 17:05:00'), 'Częstochowa', 'pielgrzymka',
    'Mercedes', ['naglosnienie', 'dwoch kierowcow'], new DateTime('2021/12/29 00:00:00'), new DateTime('2999/12/31 23:59:59'));
var_dump($testOrder);
echo "<br><br>";

echo "TEST LOGGED IN USER<br>";
$testLoggedInUser = new LoggedInUser('abc123', 1, new DateTime('2021/12/29 00:00:00'));
var_dump($testLoggedInUser);
echo "<br><br>";