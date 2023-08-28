<?php

declare(strict_types=1);

namespace App\Controller\Cluster;

use App\Entity\Cluster\Segment;
use App\Form\Cluster\SegmentType;
use App\Repository\Cluster\SegmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/cluster/segment', name: 'admin_cluster_segment_')]
class SegmentController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(SegmentRepository $segmentRepository): Response
    {
        return $this->render('cluster/segment/index.html.twig', [
            'segments' => $segmentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, SegmentRepository $segmentRepository): Response
    {
        $segment = new Segment();
        $form = $this->createForm(SegmentType::class, $segment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $segmentRepository->add($segment, true);

            return $this->redirectToRoute('admin_cluster_segment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cluster/segment/new.html.twig', [
            'segment' => $segment,
            'form' => $form,
        ]);
    }

    #[Route('/{voModeleId}/show', name: 'show', methods: ['GET'])]
    public function show(Segment $segment): Response
    {
        return $this->render('cluster/segment/show.html.twig', [
            'segment' => $segment,
        ]);
    }

    #[Route('/{voModeleId}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Segment $segment, SegmentRepository $segmentRepository): Response
    {
        $form = $this->createForm(SegmentType::class, $segment, ['edition' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $segmentRepository->add($segment, true);

            return $this->redirectToRoute('admin_cluster_segment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cluster/segment/edit.html.twig', [
            'segment' => $segment,
            'form' => $form,
        ]);
    }

    #[Route('/{voModeleId}/delete', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Segment $segment, SegmentRepository $segmentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$segment->getVoModeleId(), $request->request->get('_token'))) {
            $segmentRepository->remove($segment, true);
        }

        return $this->redirectToRoute('admin_cluster_segment_index', [], Response::HTTP_SEE_OTHER);
    }
}
