<?php

declare(strict_types=1);

namespace App\Service\Clusterisation;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractClusterisation implements ClusterisationInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private string $ruleClusterDir
    ) {
    }

    abstract public function type(): string;

    abstract public function support(): bool;

    abstract public function execute(SymfonyStyle $io): void;

    protected function serializeData(
        SymfonyStyle $io,
        string $type,
        string $className
    ): array {
        $ruleClusterFile = sprintf(
            '%s/regles_clusterisation_%s.csv',
            $this->ruleClusterDir,
            $type
        );

        $io->note(
            sprintf(
                'Importation du fichier %s %s',
                $type,
                $ruleClusterFile
            )
        );

        $fileExtension = pathinfo($ruleClusterFile, PATHINFO_EXTENSION);

        $fileString = file_get_contents($ruleClusterFile);

        return $this->serializer->deserialize($fileString, $className.'[]', $fileExtension);
    }

    protected function decodeData(
        SymfonyStyle $io,
        string $type
    ): array {
        $ruleClusterFile = sprintf(
            '%s/regles_clusterisation_%s.csv',
            $this->ruleClusterDir,
            $type
        );

        $io->note(
            sprintf(
                'Importation du fichier %s %s',
                $type,
                $ruleClusterFile
            )
        );

        $fileExtension = pathinfo($ruleClusterFile, PATHINFO_EXTENSION);

        $fileString = file_get_contents($ruleClusterFile);

        return $this->serializer->decode($fileString, $fileExtension);
    }
}
