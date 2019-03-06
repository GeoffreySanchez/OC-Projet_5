<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CouponCodeRepository")
 */
class CouponCode
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
     * @ORM\Column(type="integer")
     */
    private $ticket;

    /**
     * @ORM\Column(type="integer")
     */
    private $currentUse = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxUse;

    /**
     * @ORM\Column(type="date")
     */
    private $endDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $usable = true;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

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

    public function getTicket(): ?int
    {
        return $this->ticket;
    }

    public function setTicket(int $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }

    public function getCurrentUse(): ?int
    {
        return $this->currentUse;
    }

    public function setCurrentUse(int $currentUse): self
    {
        $this->currentUse = $currentUse;

        return $this;
    }

    public function getMaxUse(): ?int
    {
        return $this->maxUse;
    }

    public function setMaxUse(int $maxUse): self
    {
        $this->maxUse = $maxUse;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getUsable(): ?bool
    {
        return $this->usable;
    }

    public function setUsable(bool $usable): self
    {
        $this->usable = $usable;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function disableCode()
    {
        $this->usable = 0;

    }
}
