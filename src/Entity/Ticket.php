<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $usernameId;

    /**
     * @ORM\Column(type="integer")
     */
    private $prizeId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $number;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsernameId(): ?int
    {
        return $this->usernameId;
    }

    public function setUsernameId(int $usernameId): self
    {
        $this->usernameId = $usernameId;

        return $this;
    }

    public function getPrizeId(): ?int
    {
        return $this->prizeId;
    }

    public function setPrizeId(int $prizeId): self
    {
        $this->prizeId = $prizeId;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }
}
