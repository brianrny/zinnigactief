<?php
// src/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Date/Time of the last activity
     *
     * @var \Datetime
     *
     * @ORM\Column(name="last_activity_at", type="datetimetz", nullable=true)
     */
    protected $lastActivityAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Attend", mappedBy="user_id")
     */
    private $attends;

    public function __construct()
    {
        parent::__construct();
        $this->attends = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getId();
    }

    public function getLastActivityAt(): ?\DateTimeInterface
    {
        return $this->lastActivityAt;
    }
    public function setLastActivityAt(?\DateTimeInterface $lastActivityAt): self
    {
        $this->lastActivityAt = $lastActivityAt;
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
            $attend->setUserId($this);
        }

        return $this;
    }

    public function removeAttend(Attend $attend): self
    {
        if ($this->attends->contains($attend)) {
            $this->attends->removeElement($attend);
            // set the owning side to null (unless already changed)
            if ($attend->getUserId() === $this) {
                $attend->setUserId(null);
            }
        }

        return $this;
    }
}