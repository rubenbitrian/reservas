<?php

namespace App\Entity;

use App\Repository\MobileHomeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MobileHomeRepository::class)
 */
class MobileHome
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
     * @ORM\OneToMany(targetEntity=Boking::class, mappedBy="mobileHome")
     */
    private $bokings;

    public function __construct()
    {
        $this->bokings = new ArrayCollection();
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
     * @return Collection|Boking[]
     */
    public function getBokings(): Collection
    {
        return $this->bokings;
    }

    public function addBoking(Boking $boking): self
    {
        if (!$this->bokings->contains($boking)) {
            $this->bokings[] = $boking;
            $boking->setMobileHome($this);
        }

        return $this;
    }

    public function removeBoking(Boking $boking): self
    {
        if ($this->bokings->removeElement($boking)) {
            // set the owning side to null (unless already changed)
            if ($boking->getMobileHome() === $this) {
                $boking->setMobileHome(null);
            }
        }

        return $this;
    }
}
