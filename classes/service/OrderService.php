<?php
include_once '../classes/model/Order.php';
include_once '../classes/repository/OrderRepository.php';

class OrderService {
    protected OrderRepository $orderRepository;
    
    public function __construct() {
        $this->orderRepository = new OrderRepository;
        // echo "Order service created successfully!<br>"; // For test purposes
    }

    public function getAll(): ?array {
        return $this->orderRepository->getAll();
    }

    public function getById(int $orderId): ?Order {
        return $this->orderRepository->getById($orderId);
    }

    public function getByUserId(int $userId): ?array {
        return $this->orderRepository->getByUserId($userId);
    }

    public function getByClientNameOrDestination(string $clientNameOrDestination): ?array {
        return $this->orderRepository->getByClientNameOrDestination($clientNameOrDestination);
    }

    public function create(Order $order): bool {
        return $this->orderRepository->create($order);
    }

    public function update(int $orderId, Order $orderToBeUpdated): bool {
        return $this->orderRepository->update($orderId, $orderToBeUpdated);
    }

    public function updateStatus(int $orderId, int $statusToBeUpdated): bool {
        return $this->orderRepository->updateStatus($orderId, $statusToBeUpdated);
    }

    public function deleteById(int $orderId): bool {
        return $this->orderRepository->deleteById($orderId);
    }
}