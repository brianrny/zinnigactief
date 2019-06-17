<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActivityRepository")
 * @Vich\Uploadable
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
     * @Vich\UploadableField(mapping="event", fileNameProperty="fileName", size="fileSize")
     *
     * @var File
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $file_name;

    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $file_size;

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
        $this->start_date = new \DateTime();
        $this->end_date = new \DateTime();
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
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     */
    public function setFile(?File $file = null): void
    {
        $this->file = $file;

        if (null !== $file) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getFile(): ?File
    {
        return $this->file;
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

    public function setFileSize(?int $file_size): void
    {
        $this->file_size = $file_size;
    }

    public function getFileSize(): ?int
    {
        return $this->file_size;
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
