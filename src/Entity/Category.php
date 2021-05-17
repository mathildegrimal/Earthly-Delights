<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
     * @ORM\OneToMany(targetEntity=Attraction::class, mappedBy="category")
     */
    private $attractions;

    public function __construct()
    {
        $this->attractions = new ArrayCollection();
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

    /**
     * @return Collection|Attraction[]
     */
    public function getAttractions(): Collection
    {
        return $this->attractions;
    }

    public function addAttraction(Attraction $attraction): self
    {
        if (!$this->attractions->contains($attraction)) {
            $this->attractions[] = $attraction;
            $attraction->setCategory($this);
        }

        return $this;
    }

    public function removeAttraction(Attraction $attraction): self
    {
        if ($this->attractions->removeElement($attraction)) {
            // set the owning side to null (unless already changed)
            if ($attraction->getCategory() === $this) {
                $attraction->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString() {
        return $this->name;
    }

}
