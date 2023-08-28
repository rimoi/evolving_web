<?php

declare(strict_types=1);

namespace App\Entity\Cluster;

use App\Repository\Cluster\FuelRepository;
use App\Trait\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FuelRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Fuel
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private $carburantId;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $carburantCorrected;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $carburantClass;

    // YOU CAN GENERATE AFTER THIS

    public function getCarburantId(): ?int
    {
        return $this->carburantId;
    }

    public function setCarburantId(?int $carburantId): self
    {
        $this->carburantId = $carburantId;

        return $this;
    }

    public function getCarburantCorrected(): ?string
    {
        return $this->carburantCorrected;
    }

    public function setCarburantCorrected(?string $carburantCorrected): self
    {
        $this->carburantCorrected = $carburantCorrected;

        return $this;
    }

    public function getCarburantClass(): ?string
    {
        return $this->carburantClass;
    }

    public function setCarburantClass(?string $carburantClass): self
    {
        $this->carburantClass = $carburantClass;

        return $this;
    }
}
