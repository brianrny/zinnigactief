<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PeriodRepository")
 */
class Period
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start_time;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end_time;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Activity", inversedBy="periods")
     */
    private $activity_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Place", inversedBy="periods")
     */
    private $place_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Attend", mappedBy="period_id")
     */
    private $attends;

    public function __construct()
    {
        $this->attends = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->start_time;
    }

    public function setStartTime(\DateTimeInterface $start_time): self
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->end_time;
    }

    public function setEndTime(\DateTimeInterface $end_time): self
    {
        $this->end_time = $end_time;

        return $this;
    }

    public function getActivityId(): ?Activity
    {
        return $this->activity_id;
    }

    public function setActivityId(?Activity $activity_id): self
    {
        $this->activity_id = $activity_id;

        return $this;
    }

    public function getPlaceId(): ?Place
    {
        return $this->place_id;
    }

    public function setPlaceId(?Place $place_id): self
    {
        $this->place_id = $place_id;

        return $this;
    }

    /**
     * @return Collection|Attend[]
     */
    public function getAttends(): Collection
    {
        return $this->attends;
    }

    public function addAttend(Attend $attend): self
    {
        if (!$this->attends->contains($attend)) {
            $this->attends[] = $attend;
            $attend->setPeriodId($this);
        }

        return $this;
    }

    public function removeAttend(Attend $attend): self
    {
        if ($this->attends->contains($attend)) {
            $this->attends->removeElement($attend);
            // set the owning side to null (unless already changed)
            if ($attend->getPeriodId() === $this) {
                $attend->setPeriodId(null);
            }
        }

        return $this;
    }
}
