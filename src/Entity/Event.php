<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
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
     * @ORM\Column(type="datetime")
     */
    private $start_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end_date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="events")
     */
    private $location_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EventHasActivity", mappedBy="event_id")
     */
    private $eventHasActivities;

    public function __construct()
    {
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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getLocationId(): ?Location
    {
        return $this->location_id;
    }

    public function setLocationId(?Location $location_id): self
    {
        $this->location_id = $location_id;

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
            $eventHasActivity->setEventId($this);
        }

        return $this;
    }

    public function removeEventHasActivity(EventHasActivity $eventHasActivity): self
    {
        if ($this->eventHasActivities->contains($eventHasActivity)) {
            $this->eventHasActivities->removeElement($eventHasActivity);
            // set the owning side to null (unless already changed)
            if ($eventHasActivity->getEventId() === $this) {
                $eventHasActivity->setEventId(null);
            }
        }

        return $this;
    }
}
