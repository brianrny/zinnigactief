<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @Vich\Uploadable
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
     * @Vich\UploadableField(mapping="event", fileNameProperty="fileName", size="fileSize")
     *
     * @var File
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $file_name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer
     */
    private $file_size;

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
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EventHasActivity", mappedBy="event_id")
     */
    private $eventHasActivities;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;


    public function __construct()
    {
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

    public function setName(?string $name): self
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

    public function setFileName(?string $file_name): self
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

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
