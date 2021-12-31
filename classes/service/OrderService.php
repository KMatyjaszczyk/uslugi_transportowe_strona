<?php
include_once '../classes/model/Order.php';
include_once '../classes/repository/OrderRepository.php';
// TODO write class
class OrderService {
    protected OrderRepository $orderRepository;
    
    public function __construct() {
        $this->orderRepository = new OrderRepository;
        echo "Order service created successfully!<br>"; // For test purposes
    }
}