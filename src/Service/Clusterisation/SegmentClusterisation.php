<?php

declare(strict_types=1);

namespace App\Service\Clusterisation;

use App\Constant\ClusterConstant;
use App\Entity\Cluster\Segment;
use Symfony\Component\Console\Style\SymfonyStyle;

class SegmentClusterisation extends AbstractClusterisation
{
    public function type(): string
    {
        return ClusterConstant::SEGMENT;
    }

    public function support(): bool
    {
        return ClusterConstant::SEGMENT === $this->type();
    }

    public function execute(SymfonyStyle $io): void
    {
        /** @var Segment[] $segments */
        $segments = $this->serializeData($io, ClusterConstant::SEGMENT, Segment::class);

        foreach ($segments as $key => $segment) {
            if ($segmentExiste = $this->entityManager->getRepository(Segment::class)->find($segment->getVoModeleId())) {
                $segmentExiste->setSegmentClass($segment->getSegmentClass());
                $segmentExiste->setSegmentName($segment->getSegmentName());

                unset($segments[$key]);
            } else {
                $this->entityManager->persist($segment);
            }
        }

        $this->entityManager->flush();
    }
}
