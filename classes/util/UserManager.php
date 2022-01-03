<?php
include_once '../classes/model/User.php';
include_once '../classes/model/LoggedInUser.php';
include_once '../classes/service/UserService.php';
include_once '../classes/service/LoggedInUserService.php';

class UserManager {
    protected UserService $userService;
    protected LoggedInUserService $loggedInUserService;

    public function __construct() {
        $this->userService = new UserService();
        $this->loggedInUserService = new LoggedInUserService();
        // echo "User Manager created successfully!<br>"; // For test purposes
    }

    public function login(): ?int {
        $filteredCredentials = $this->filterCredentials();
        $login = $filteredCredentials["login"];
        $password = $filteredCredentials["password"];
        $userId = null;

        $userToBeChecked = $this->userService->getByLogin($login);
        if ($userToBeChecked !== null) {
            $passwordVerifyResult = password_verify($password, $userToBeChecked->getPassword());
            if ($passwordVerifyResult) {
                $userId = $this->createNewSession($userToBeChecked);
            }
        }
        return $userId;
    }

    private function filterCredentials(): array {
        $arguments = [
            "login" => FILTER_SANITIZE_ADD_SLASHES,
            "password" => FILTER_SANITIZE_ADD_SLASHES
        ];
        return filter_input_array(INPUT_POST, $arguments);
    }

    private function createNewSession(User $user): int {
        $this->loggedInUserService->deleteByUserId($user->getId());
        session_start();
        $this->loggedInUserService->create(new LoggedInUser(
            session_id(),
            $user->getId(),
            new DateTime()
        ));
        return $user->getId();
    }

    public function logout(string $sessionId): bool {
        // TODO: implement method
        return false;
    }
}