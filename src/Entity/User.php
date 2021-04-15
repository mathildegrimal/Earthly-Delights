<?php

namespace App\Entity;
use Symfony\Component\String\Slugger\AsciiSlugger;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
        min = 2,
        max = 255,
        minMessage = "Votre prénom doit faire au moins {{ limit }} caractères",
        maxMessage = "Votre prénom doit faire au maximum  {{ limit }} characters"
    )
    */
    
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
        min = 2,
        max = 255,
        minMessage = "Votre pseudo doit faire au moins {{ limit }} caractères",
        maxMessage = "Votre pseudo doit faire au maximum  {{ limit }} characters"
    )
    */
    private $nickname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
        min = 4,
        max = 255,
        minMessage = "Votre nom doit faire au moins {{ limit }} caractères",
        maxMessage = "Votre nom doit faire au maximum  {{ limit }} characters"
    )
    */
    private $lastname;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive(message="l'âge doit être un nombre supérieur à 0")
     */

    private $age;

    /**
     * @ORM\OneToMany(targetEntity=Booking::class, mappedBy="UserHasManyBookings", cascade={"persist"})
     */
    private $bookings;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->rates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

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
            $booking->setUserHasManyBookings($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getUserHasManyBookings() === $this) {
                $booking->setUserHasManyBookings(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $slugger = new AsciiSlugger();
        $slugged = $slugger->slug($slug);
        $this->slug = $slugged;
        return $this;

    }

}
