<?php

declare(strict_types=1);

namespace App\Trait;

use Doctrine\ORM\Mapping as ORM;

trait TimestampableEntity
{
    #[ORM\Column(type: 'datetime')]
    protected $createdAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    protected $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
    }

    #[ORM\PreUpdate]
    public function setUpdatedAt(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function updateDate(?\DateTimeInterface $date): void
    {
        $this->updatedAt = $date;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $date): void
    {
        $this->createdAt = $date;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }
}
