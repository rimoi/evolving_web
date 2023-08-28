<?php

declare(strict_types=1);

namespace App\Service\Clusterisation;

use App\Constant\ClusterConstant;
use App\Entity\Cluster\Fuel;
use Symfony\Component\Console\Style\SymfonyStyle;

class FuelClusterisation extends AbstractClusterisation
{
    public function type(): string
    {
        return ClusterConstant::FUEL;
    }

    public function support(): bool
    {
        return ClusterConstant::FUEL === $this->type();
    }

    public function execute(SymfonyStyle $io): void
    {
        $fuels = $this->serializeData($io, ClusterConstant::FUEL, Fuel::class);

        foreach ($fuels as $key => $fuel) {
            if ($fuelExiste = $this->entityManager->getRepository(Fuel::class)->find($fuel->getCarburantId())) {
                $fuelExiste->setCarburantClass($fuel->getCarburantClass());
                $fuelExiste->setCarburantCorrected($fuel->getCarburantCorrected());

                unset($fuels[$key]);
            } else {
                $this->entityManager->persist($fuel);
            }
        }

        $this->entityManager->flush();
    }
}
