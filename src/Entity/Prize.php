<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\SecurityBundle\Tests\DependencyInjection\Fixtures\UserProvider\DummyProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PrizeRepository")
 */
class Prize
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", length=255)
     */
    private $currentTicket = 0;

    /**
     * @ORM\Column(type="integer", length=255)
     */
    private $goal;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visible = true;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $winner;

    public $duration;


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

    public function getCurrentTicket(): ?string
    {
        return $this->currentTicket;
    }

    public function setCurrentTicket(string $currentTicket): self
    {
        $this->currentTicket = $currentTicket;

        return $this;
    }

    public function getGoal(): ?string
    {
        return $this->goal;
    }

    public function setGoal(string $goal): self
    {
        $this->goal = $goal;

        return $this;
    }

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }


    public function setEndDate($endDate): self
    {
        if($endDate == null) {
            $this->endDate = new \DateTime("+$this->duration day");
        } else {
            $this->endDate = $endDate;
        }
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        if($visible == null) {
            $visible == false;
        }
        $this->visible = $visible;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getWinner(): ?string
    {
        return $this->winner;
    }

    public function setWinner(string $winner): self
    {
        $this->winner = $winner;

        return $this;
    }

    public function pourcentage()
    {
        return $this->currentTicket * 100 / $this->goal;
    }

    public function ticketToGoal()
    {
        return $this->goal - $this->currentTicket;
    }

    public function strEndDate()
    {
        return $this->endDate->format('d-m-Y à H:i:s');
    }

    public function nombreJoueur($nombre){
        $this->nombreJoueur = $nombre;
        return $this;
    }

    public function endPrize()
    {
        $currentDate = new \DateTime();
        if ($this->endDate <= $currentDate)
        {
            $this->visible = false;
        }
    }

    public function winnerIs($winnerIs)
    {
        $this->winner = $winnerIs;
        $this->visible = false;
    }
}
