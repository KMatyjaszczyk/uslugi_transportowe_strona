<?php
class Order {
    public static int $STATUS_CREATED = 1;
    public static int $STATUS_CANCELLED = 2;
    public static int $STATUS_ACCEPTED = 3;
    public static int $STATUS_REALISED = 4;

    protected ?int $id;
    protected ?int $userId;
    protected string $clientName;
    protected string $clientEmail;
    protected DateTime $departureDate;
    protected string $destination;
    protected string $journeyForm;
    protected string $vehicle;
    protected array $additionalServices;
    protected int $status;
    protected ?DateTime $creationDate;
    protected ?DateTime $lastUpdatedDate;

    public function __construct(?int $id, ?int $userId, string $clientName, string $clientEmail,
            DateTime $departureDate, string $destination, string $journeyForm,
            string $vehicle, array $additionalServices, int $status,
            ?DateTime $creationDate, ?DateTime $lastUpdatedDate
            ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->clientName = $clientName;
        $this->clientEmail = $clientEmail;
        $this->departureDate = $departureDate;
        $this->destination = $destination;
        $this->journeyForm = $journeyForm;
        $this->vehicle = $vehicle;
        $this->additionalServices = $additionalServices;
        $this->status = $status;
        $this->creationDate = $creationDate;
        $this->lastUpdatedDate = $lastUpdatedDate;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getUserId(): ?int {
        return $this->userId;
    }

    public function getClientName(): string {
        return $this->clientName;
    }

    public function getClientEmail(): string {
        return $this->clientEmail;
    }

    public function getDepartureDate(): DateTime {
        return $this->departureDate;
    }

    public function getDestination(): string {
        return $this->destination;
    }

    public function getJourneyForm(): string {
        return $this->journeyForm;
    }

    public function getVehicle(): string {
        return $this->vehicle;
    }

    public function getAdditionalServices(): array {
        return $this->additionalServices;
    }

    public function getStatus(): int {
        return $this->status;
    }

    public function getCreationDate(): ?DateTime {
        return $this->creationDate;
    }

    public function getLastUpdatedDate(): ?DateTime {
        return $this->lastUpdatedDate;
    }
}