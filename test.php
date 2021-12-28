<?php
include_once './classes/model/User.php';
include_once './classes/model/Order.php';

echo "TEST USER<br>";
$testUser = new User(1, 'admin', 'admin', 'admin@admin.pl', true);
var_dump($testUser);
echo "<br><br>";

echo "TEST ORDER<br>";
$testOrder = new Order(1, 'Jan Kowalski Sp. z o.o.', 'jan.kowalski@gmail.com', 
    new DateTime('2022/01/12 17:05:00'), 'Częstochowa', 'pielgrzymka',
    'Mercedes', ['naglosnienie', 'dwoch kierowcow'], new DateTime(), new DateTime('2999/12/31 23:59:59'));
var_dump($testOrder);
echo "<br><br>";