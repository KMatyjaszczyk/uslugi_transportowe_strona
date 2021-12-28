<?php
class Order {
    protected int $id;
    protected string $clientName;
    protected string $clientEmail;
    protected DateTime $departureDate;
    protected string $destination;
    protected string $journeyForm;
    protected string $vehicle;
    protected array $additionalServices;
    protected DateTime $creationDate;
    protected DateTime $lastUpdatedDate;

    public function __construct(int $id, string $clientName, string $clientEmail,
            DateTime $departureDate, string $destination, string $journeyForm,
            string $vehicle, array $additionalServices, 
            DateTime $creationDate = new DateTime(), DateTime $lastUpdatedDate = null
            ) {
        $this->id = $id;
        $this->clientName = $clientName;
        $this->clientEmail = $clientEmail;
        $this->departureDate = $departureDate;
        $this->destination = $destination;
        $this->journeyForm = $journeyForm;
        $this->vehicle = $vehicle;
        $this->additionalServices = $additionalServices;
        $this->creationDate = $creationDate;
        $this->lastUpdatedDate = $lastUpdatedDate;
    }

    public function getId(): int {
        return $this->id;
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

    public function getCreationDate(): DateTime {
        return $this->creationDate;
    }

    public function getLastUpdatedDate(): DateTime {
        return $this->lastUpdatedDate;
    }
}