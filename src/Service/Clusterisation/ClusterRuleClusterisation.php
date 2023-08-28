<?php

declare(strict_types=1);

namespace App\Service\Clusterisation;

use App\Constant\ClusterConstant;
use App\Entity\Cluster\ClusterRule;
use Symfony\Component\Console\Style\SymfonyStyle;

class ClusterRuleClusterisation extends AbstractClusterisation
{
    public function type(): string
    {
        return ClusterConstant::CLUSTER_RULE;
    }

    public function support(): bool
    {
        return ClusterConstant::CLUSTER_RULE === $this->type();
    }

    public function execute(SymfonyStyle $io): void
    {
        $clusterRules = $this->decodeData($io, ClusterConstant::CLUSTER_RULE);

        foreach ($clusterRules as $clusterRule) {
            if (!$clusterRuleEntity = $this->entityManager->getRepository(ClusterRule::class)->find($clusterRule['cluster'])) {
                $clusterRuleEntity = new ClusterRule();
                $clusterRuleEntity->setCluster(
                    $clusterRule['cluster']
                );
                $this->entityManager->persist($clusterRuleEntity);
            }
            $clusterRuleEntity->setFinalBpB2c(
                (float) str_replace(',', '.', $clusterRule['final_BP/B2C'])
            );
            $clusterRuleEntity->setFinalBpB2cMin(
                (float) str_replace(',', '.', $clusterRule['final_BP/B2C_min'])
            );
            $clusterRuleEntity->setFinalBpB2cMax(
                (float) str_replace(',', '.', $clusterRule['final_BP/B2C_max'])
            );
            $clusterRuleEntity->setFinalCpB2cMax(
                (float) str_replace(',', '.', $clusterRule['final_CP/B2C_max'])
            );
            $clusterRuleEntity->setFinalCpB2c(
                (float) str_replace(',', '.', $clusterRule['final_CP/B2C'])
            );
            $clusterRuleEntity->setFinalCpB2cMin(
                (float) str_replace(',', '.', $clusterRule['final_CP/B2C_min'])
            );
        }

        $this->entityManager->flush();
    }
}
