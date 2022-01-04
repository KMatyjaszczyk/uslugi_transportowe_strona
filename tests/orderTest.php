<?php
include_once '../classes/Order.php';
include_once '../classes/OrderRepository.php';
include_once '../classes/OrderService.php';

echo "TEST ORDER<br>";
$testOrder = new Order(1, 2, 'Jan Kowalski Sp. z o.o.', 'jan.kowalski@gmail.com',
    new DateTime('2022/01/12 17:05:00'), 'Częstochowa', 'pielgrzymka',
    'Mercedes', ['naglosnienie', 'kierowcy'], 1, 
    new DateTime('2021/12/29 00:00:00'), new DateTime('2999/12/31 23:59:59'));
var_dump($testOrder);
echo "<br><br>";

echo "<hr><br><br>";

echo "TEST OPEN ORDER REPOSITORY<br>";
$testOrderRepository = new OrderRepository();
var_dump($testOrderRepository);
echo "<br><br>";

echo "TEST ORDER REPOSITORY - GET ALL<br>";
$getAllResult = $testOrderRepository->getAll();
var_dump($getAllResult);
echo "<br><br>";

echo "TEST ORDER REPOSITORY - GET BY ID<br>";
$getByIdResult = $testOrderRepository->getById(5);
echo "<br>=======<br>";
var_dump($getByIdResult);
echo "<br><br>";

echo "TEST ORDER REPOSITORY - GET BY USER ID<br>";
$getByUserIdResult = $testOrderRepository->getByUserId(1);
echo "<br>=======<br>";
var_dump($getByUserIdResult);
echo "<br><br>";

echo "TEST ORDER REPOSITORY - GET BY CLIENT NAME OR DESTINATION<br>";
$getByClientNameOrDestinationResult = $testOrderRepository->getByClientNameOrDestination("Częstochowa");
echo "<br>=======<br>";
var_dump($getByClientNameOrDestinationResult);
echo "<br><br>";

// echo "TEST ORDER REPOSITORY - CREATE<br>";
// $orderToBeCreated = new Order(null, 2, 'Jan Kowalski Sp. z o.o.', 'jan.kowalski@gmail.com',
//     new DateTime('2022/01/12 17:05:00'), 'Częstochowa', 'pielgrzymka',
//     'Mercedes', ['naglosnienie'], 1, null, null);
// $createResult = $testOrderRepository->create($orderToBeCreated);
// var_dump($createResult);
// echo "<br><br>";

echo "TEST ORDER REPOSITORY - UPDATE<br>";
$orderToBeUpdated = new Order(null, null, 'JANUSZEX', 'jan.kowalski@gmail.com', 
    new DateTime('2022/01/12 17:05:00'), 'Częstochowa', 'pielgrzymka',
    'Mercedes', [], 1, null, null);
$updateResult = $testOrderRepository->update(5, $orderToBeUpdated);
var_dump($updateResult);
echo "<br><br>";

echo "TEST ORDER REPOSITORY - UPDATE STATUS<br>";
$updateStatusResult = $testOrderRepository->updateStatus(6, 3);
var_dump($updateStatusResult);
echo "<br><br>";

echo "TEST ORDER REPOSITORY - DELETE<br>";
$orderDeleteByIdResult = $testOrderRepository->deleteById(35);
var_dump($orderDeleteByIdResult);
echo "<br><br>";

echo "<hr><br><br>";

echo "TEST CREATE ORDER SERVICE<br>";
$testOrderService = new OrderService();
var_dump($testOrderService);
echo "<br><br>";