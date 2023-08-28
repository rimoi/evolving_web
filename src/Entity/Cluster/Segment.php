<?php

declare(strict_types=1);

namespace App\Entity\Cluster;

use App\Repository\Cluster\SegmentRepository;
use App\Trait\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SegmentRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Segment
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private $voModeleId;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $segmentName;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $segmentClass;

    public function getVoModeleId(): ?int
    {
        return $this->voModeleId;
    }

    public function setVoModeleId(?int $segmentId): self
    {
        $this->voModeleId = $segmentId;

        return $this;
    }

    public function getSegmentName(): ?string
    {
        return $this->segmentName;
    }

    public function setSegmentName(?string $segmentName): self
    {
        $this->segmentName = $segmentName;

        return $this;
    }

    public function getSegmentClass(): ?string
    {
        return $this->segmentClass;
    }

    public function setSegmentClass(?string $segmentClass): self
    {
        $this->segmentClass = $segmentClass;

        return $this;
    }
}
