<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActivityRepository")
 */
class Activity
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
     * @ORM\Column(type="string", length=255)
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $file_name;

    /**
     * @ORM\Column(type="integer")
     */
    private $max_people;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Period", mappedBy="activity_id")
     */
    private $periods;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EventHasActivity", mappedBy="activity_id")
     */
    private $eventHasActivities;

    public function __construct()
    {
        $this->periods = new ArrayCollection();
        $this->eventHasActivities = new ArrayCollection();
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

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->file_name;
    }

    public function setFileName(string $file_name): self
    {
        $this->file_name = $file_name;

        return $this;
    }

    public function getMaxPeople(): ?int
    {
        return $this->max_people;
    }

    public function setMaxPeople(int $max_people): self
    {
        $this->max_people = $max_people;

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

    /**
     * @return Collection|Period[]
     */
    public function getPeriods(): Collection
    {
        return $this->periods;
    }

    public function addPeriod(Period $period): self
    {
        if (!$this->periods->contains($period)) {
            $this->periods[] = $period;
            $period->setActivityId($this);
        }

        return $this;
    }

    public function removePeriod(Period $period): self
    {
        if ($this->periods->contains($period)) {
            $this->periods->removeElement($period);
            // set the owning side to null (unless already changed)
            if ($period->getActivityId() === $this) {
                $period->setActivityId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EventHasActivity[]
     */
    public function getEventHasActivities(): Collection
    {
        return $this->eventHasActivities;
    }

    public function addEventHasActivity(EventHasActivity $eventHasActivity): self
    {
        if (!$this->eventHasActivities->contains($eventHasActivity)) {
            $this->eventHasActivities[] = $eventHasActivity;
            $eventHasActivity->setActivityId($this);
        }

        return $this;
    }

    public function removeEventHasActivity(EventHasActivity $eventHasActivity): self
    {
        if ($this->eventHasActivities->contains($eventHasActivity)) {
            $this->eventHasActivities->removeElement($eventHasActivity);
            // set the owning side to null (unless already changed)
            if ($eventHasActivity->getActivityId() === $this) {
                $eventHasActivity->setActivityId(null);
            }
        }

        return $this;
    }
}
