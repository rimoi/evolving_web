<?php

declare(strict_types=1);

namespace App\Service\Clusterisation;

use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.clustorisation_rules')]
interface ClusterisationInterface
{
    public function type(): string;

    public function support(): bool;

    public function execute(SymfonyStyle $io): void;
}
