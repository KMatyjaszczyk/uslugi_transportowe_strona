<?php
class LoggedInUser {
    protected string $sessionId;
    protected int $userId;
    protected DateTime $lastUpdateDate;

    public function __construct(string $sessionId, int $userId, DateTime $lastUpdateDate) {
        $this->sessionId = $sessionId;
        $this->userId = $userId;
        $this->lastUpdateDate = $lastUpdateDate;
    }

    public function getSessionId(): int {
        return $this->sessionId;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getLastUdateDate(): DateTime {
        return $this->lastUpdateDate;
    }
}