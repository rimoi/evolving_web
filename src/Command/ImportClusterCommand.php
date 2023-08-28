<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

#[AsCommand(
    name: 'app:import-cluster',
    description: 'Importer les règles de clusterisations',
)]
class ImportClusterCommand extends Command
{
    public function __construct(
        #[TaggedIterator('app.clustorisation_rules')]
        private iterable $clusterisationRules
    ) {
        parent::__construct(null);
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        foreach ($this->clusterisationRules as $clusterisationRule) {
            if ($clusterisationRule->support()) {
                $clusterisationRule->execute($io);
            }
        }

        $io->success('Terminé !');

        return Command::SUCCESS;
    }
}
