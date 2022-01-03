<?php
include_once '../classes/model/LoggedInUser.php';
include_once '../classes/repository/LoggedInUserRepository.php';

class LoggedInUserService {
    protected LoggedInUserRepository $loggedInUserRepository;

    public function __construct() {
        $this->loggedInUserRepository = new LoggedInUserRepository();
        // echo "Logged in User service created successfully!<br>"; // For test purposes
    }

    public function getBySessionId(string $sessionId): ?LoggedInUser {
        return $this->loggedInUserRepository->getBySessionId($sessionId);
    }

    public function getByUserId(string $userId): ?array {
        return $this->loggedInUserRepository->getByUserId($userId);
    }

    public function create(LoggedInUser $loggedInUser): bool {
        return $this->loggedInUserRepository->create($loggedInUser);
    }

    public function deleteBySessionId(string $sessionId): bool {
        return $this->loggedInUserRepository->deleteBySessionId($sessionId);
    }

    public function deleteByUserId(int $userId): bool {
        return $this->loggedInUserRepository->deleteByUserId($userId);
    }
}