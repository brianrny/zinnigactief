<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AttendRepository")
 */
class Attend
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Period", inversedBy="attends")
     */
    private $period_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="attends")
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $speaker;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $present;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $payed;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPeriodId(): ?Period
    {
        return $this->period_id;
    }

    public function setPeriodId(?Period $period_id): self
    {
        $this->period_id = $period_id;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getSpeaker(): ?string
    {
        return $this->speaker;
    }

    public function setSpeaker(string $speaker): self
    {
        $this->speaker = $speaker;

        return $this;
    }

    public function getPresent(): ?string
    {
        return $this->present;
    }

    public function setPresent(string $present): self
    {
        $this->present = $present;

        return $this;
    }

    public function getPayed(): ?string
    {
        return $this->payed;
    }

    public function setPayed(string $payed): self
    {
        $this->payed = $payed;

        return $this;
    }
}
