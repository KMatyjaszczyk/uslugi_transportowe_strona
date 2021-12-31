<?php
include_once '../classes/model/LoggedInUser.php';
include_once '../classes/repository/LoggedInUserRepository.php';
// TODO write class
class LoggedInUserService {
    protected LoggedInUserRepository $loggedInUserRepository;

    public function __construct() {
        $this->loggedInUserRepository = new LoggedInUserRepository();
        echo "Logged in User service created successfully!<br>"; // For test purposes
    }
}