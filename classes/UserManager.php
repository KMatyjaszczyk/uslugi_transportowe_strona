<?php
include_once 'User.php';
include_once 'LoggedInUser.php';
include_once 'UserService.php';
include_once 'LoggedInUserService.php';

class UserManager {
    protected UserService $userService;
    protected LoggedInUserService $loggedInUserService;

    public function __construct() {
        $this->userService = new UserService();
        $this->loggedInUserService = new LoggedInUserService();
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
        $sessionName = session_name();
        if (isset($_COOKIE[$sessionName])) {
            setcookie($sessionName, '', time() - 42000, '/');
        }
        $sessionDestroyResult = session_destroy();
        $deleteLoggedInUserResult = $this->loggedInUserService->deleteBySessionId($sessionId);
        return $sessionDestroyResult && $deleteLoggedInUserResult;
    }

    public function retrieveSessionId(): ?string {
        $sessionId = null;
        $sessionName = session_name();
        if (isset($_COOKIE[$sessionName])) {
            session_start();
            $sessionId = session_id();
        }
        return $sessionId;
    }

    public function isUserLoggedIn(?string $sessionId): bool {
        if ($sessionId === null) {
            return false;
        }
        $loggedInUser = $this->loggedInUserService->getBySessionId($sessionId);
        return $loggedInUser !== null;
    }
}