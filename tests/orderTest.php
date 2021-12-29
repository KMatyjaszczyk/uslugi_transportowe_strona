<?php
include_once '../classes/model/Order.php';
include_once '../classes/repository/OrderRepository.php';

echo "TEST ORDER<br>";
$testOrder = new Order(1, 'Jan Kowalski Sp. z o.o.', 'jan.kowalski@gmail.com', 
    new DateTime('2022/01/12 17:05:00'), 'Częstochowa', 'pielgrzymka',
    'Mercedes', ['naglosnienie', 'dwoch kierowcow'], new DateTime('2021/12/29 00:00:00'), new DateTime('2999/12/31 23:59:59'));
var_dump($testOrder);
echo "<br><br>";

echo "TEST OPEN ORDER REPOSITORY<br>";
$testOrderRepository = new OrderRepository();
var_dump($testOrderRepository);
echo "<br><br>";

echo "TEST ORDER REPOSITORY - GET ALL<br>";
$getAllResult = $testOrderRepository->getAll();
var_dump($getAllResult);
echo "<br><br>";

echo "TEST ORDER REPOSITORY - GET BY ID<br>";
$getByIdResult = $testOrderRepository->getById(2);
var_dump($getByIdResult);
echo "<br><br>";

echo "TEST ORDER REPOSITORY - CREATE<br>";
$orderToBeCreated = new Order(null, 'Jan Kowalski Sp. z o.o.', 'jan.kowalski@gmail.com', 
    new DateTime('2022/01/12 17:05:00'), 'Częstochowa', 'pielgrzymka',
    'Mercedes', ['naglosnienie', 'dwoch kierowcow'], null, null);
$createResult = $testOrderRepository->create($orderToBeCreated);
var_dump($createResult);
echo "<br><br>";

echo "TEST ORDER REPOSITORY - UPDATE<br>";
$orderToBeUpdated = new Order(null, 'JANUSZEX', 'jan.kowalski@gmail.com', 
    new DateTime('2022/01/12 17:05:00'), 'Częstochowa', 'pielgrzymka',
    'Mercedes', ['naglosnienie', 'kierowcy'], null, null);
$updateResult = $testOrderRepository->update(5, $orderToBeUpdated);
var_dump($updateResult);
echo "<br><br>";