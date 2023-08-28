<?php

declare(strict_types=1);

namespace App\Entity\Cluster;

use App\Repository\Cluster\ClusterRuleRepository;
use App\Trait\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ClusterRuleRepository::class)]
#[UniqueEntity(fields: ['cluster'], message: 'On ne peut pas avoir deux clusters avec la même règle !')]
class ClusterRule
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    private $cluster;

    #[ORM\Column(type: 'float', nullable: true)]
    private $finalCpB2cMin;

    #[ORM\Column(type: 'float', nullable: true)]
    private $finalCpB2c;

    #[ORM\Column(type: 'float', nullable: true)]
    private $finalBpB2cMax;

    #[ORM\Column(type: 'float', nullable: true)]
    private $finalCpB2CMax;

    #[ORM\Column(type: 'float', nullable: true)]
    private $finalBpB2cMin;

    #[ORM\Column(type: 'float', nullable: true)]
    private $finalBpB2c;

    public function getCluster(): ?string
    {
        return $this->cluster;
    }

    public function setCluster(?string $cluster): self
    {
        $this->cluster = $cluster;

        return $this;
    }

    public function getFinalCpB2cMin(): ?float
    {
        return $this->finalCpB2cMin;
    }

    public function setFinalCpB2cMin(?float $finalCpB2cMin): self
    {
        $this->finalCpB2cMin = $finalCpB2cMin;

        return $this;
    }

    public function getFinalCpB2c(): ?float
    {
        return $this->finalCpB2c;
    }

    public function setFinalCpB2c(?float $finalCpB2c): self
    {
        $this->finalCpB2c = $finalCpB2c;

        return $this;
    }

    public function getFinalBpB2cMax(): ?float
    {
        return $this->finalBpB2cMax;
    }

    public function setFinalBpB2cMax(?float $finalBpB2cMax): self
    {
        $this->finalBpB2cMax = $finalBpB2cMax;

        return $this;
    }

    public function getFinalCpB2CMax(): ?float
    {
        return $this->finalCpB2CMax;
    }

    public function setFinalCpB2CMax(?float $finalCpB2CMax): self
    {
        $this->finalCpB2CMax = $finalCpB2CMax;

        return $this;
    }

    public function getFinalBpB2cMin(): ?float
    {
        return $this->finalBpB2cMin;
    }

    public function setFinalBpB2cMin(?float $finalBpB2cMin): self
    {
        $this->finalBpB2cMin = $finalBpB2cMin;

        return $this;
    }

    public function getFinalBpB2c(): ?float
    {
        return $this->finalBpB2c;
    }

    public function setFinalBpB2c(?float $finalBpB2c): self
    {
        $this->finalBpB2c = $finalBpB2c;

        return $this;
    }
}
