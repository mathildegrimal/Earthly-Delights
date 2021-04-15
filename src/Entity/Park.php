<?php

namespace App\Entity;

use App\Repository\ParkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParkRepository::class)
 */
class Park
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacity;

    /**
     * @ORM\Column(type="float")
     */
    private $entryPrice;

    /**
     * @ORM\Column(type="float")
     */
    private $totalIncome=0;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="ParkHasManyBookings", cascade={"persist"})
     */
    private $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getEntryPrice(): ?float
    {
        return $this->entryPrice;
    }

    public function setEntryPrice(float $entryPrice): self
    {
        $this->entryPrice = $entryPrice;

        return $this;
    }

    public function getTotalIncome(): ?float
    {
        return $this->totalIncome;
    }

    public function setTotalIncome(): self
    {
        $total=0;

        foreach($this->getBookings() as $booking){
            $total += $booking->getTotalBookingPrice();
            
        }
        $this->totalIncome = $total;

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setParkHasManyBookings($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getParkHasManyBookings() === $this) {
                $booking->setParkHasManyBookings(null);
            }
        }

        return $this;
    }
}
