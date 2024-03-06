<?php
namespace App\Service;

use App\Entity\Reservation;
use App\Entity\SubscriptionPlan;
use Doctrine\ORM\EntityManagerInterface;

class ReservationService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createReservation(\DateTimeInterface $date, ?string $description, SubscriptionPlan $subscriptionPlan): Reservation
    {
        // Create a new reservation
        $reservation = new Reservation();
        $reservation->setDate($date);
        $reservation->setDescription($description);
        $reservation->setSubscriptionPlan($subscriptionPlan);

        // Persist the reservation to the database
        $this->entityManager->persist($reservation);
        $this->entityManager->flush();

        return $reservation;
    }

    public function deleteReservation(Reservation $reservation): void
    {
        // Delete the reservation from the database
        $this->entityManager->remove($reservation);
        $this->entityManager->flush();
    }

    public function updateReservation(Reservation $reservation, \DateTimeInterface $date, ?string $description, SubscriptionPlan $subscriptionPlan): void
    {
        // Update the reservation with new data
        $reservation->setDate($date);
        $reservation->setDescription($description);
        $reservation->setSubscriptionPlan($subscriptionPlan);

        // Persist the updated reservation to the database
        $this->entityManager->flush();
    }
}
