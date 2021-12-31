<?php
include_once '../classes/model/User.php';
include_once '../classes/repository/UserRepository.php';
// TODO write class
class UserService {
    protected UserRepository $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
        echo "User service created successfully!<br>"; // For test purposes
    }
}