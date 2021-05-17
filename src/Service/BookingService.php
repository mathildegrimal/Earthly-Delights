<?php

namespace App\Service;

use App\Entity\Booking;
use App\Entity\Park;
use Doctrine\ORM\EntityManagerInterface;

class BookingService {


    private $entityManager;
    private $park;
    private $capacity;
    private $entryPrice;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
        $this->park = $this->entityManager->getRepository(Park::class)->findAll();
        $this->capacity = $this->park[0]->getCapacity();
        $this->entryPrice = $this->park[0]->getEntryPrice();
    }

    public function getEntryPrice(): ?float {
        return $this->entryPrice;
    }
        
    public function newBooking($booking,$user){
        
       
        $this->setTotalEntryPrice($booking);         
        $this->setBookingRef($booking, $user);        
        $user->addBooking($booking);
        $this->park[0]->addBooking($booking);
        $this->park[0]->setTotalIncome();
        $this->entityManager->persist($user);    
        $this->entityManager->flush();
    }

    public function seatsAvailable($booking) {
        $date = $booking->getDate();
        $bookings = $this->entityManager->getRepository(Booking::class)->findBy(['date' => $date]);
        $totalOfDay = 0;
        foreach ($bookings as $b) {
            $totalOfDay += $b->getNbOfSeats();
        }
        if ($totalOfDay<$this->capacity) {
            return true;
        } elseif ($totalOfDay>=$this->capacity) {
            return false;
        }
    }

    public function setTotalEntryPrice($booking){
       
        $nbOfSeats = $booking->getNbOfSeats();
        $totalPrice = $this->entryPrice * $nbOfSeats;
        $booking->setTotalBookingPrice($totalPrice);
    }

    public function setBookingRef($booking, $user){
        $date=$booking->getDate();
        $dateString=$date->format('Y-m-d');
        $nickname = $user->getSlug();
        $random=rand(100000,999999);
        $ref = $nickname.'-'.$dateString.'-'.$random;
        $booking->setBookingRef($ref);
    }

    public function deleteBooking($booking){
        $this->entityManager->remove($booking);
        $this->entityManager->flush();
        $this->park[0]->setTotalIncome();
        $this->entityManager->flush();
    }
    

}

