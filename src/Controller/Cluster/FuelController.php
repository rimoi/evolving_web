<?php

declare(strict_types=1);

namespace App\Controller\Cluster;

use App\Entity\Cluster\Fuel;
use App\Form\Cluster\FuelType;
use App\Repository\Cluster\FuelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cluster/fuel', name: 'admin_cluster_fuel_')]
class FuelController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(FuelRepository $fuelRepository): Response
    {
        return $this->render('cluster/fuel/index.html.twig', [
            'fuels' => $fuelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, FuelRepository $fuelRepository): Response
    {
        $fuel = new Fuel();
        $form = $this->createForm(FuelType::class, $fuel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fuelRepository->add($fuel, true);

            return $this->redirectToRoute('admin_cluster_fuel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cluster/fuel/new.html.twig', [
            'fuel' => $fuel,
            'form' => $form,
        ]);
    }

    #[Route('/{carburantId}/show', name: 'show', methods: ['GET'])]
    public function show(Fuel $fuel): Response
    {
        return $this->render('cluster/fuel/show.html.twig', [
            'fuel' => $fuel,
        ]);
    }

    #[Route('/{carburantId}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fuel $fuel, FuelRepository $fuelRepository): Response
    {
        $form = $this->createForm(FuelType::class, $fuel, ['edition' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fuelRepository->add($fuel, true);

            return $this->redirectToRoute('admin_cluster_fuel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cluster/fuel/edit.html.twig', [
            'fuel' => $fuel,
            'form' => $form,
        ]);
    }

    #[Route('/{carburantId}/delete', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Fuel $fuel, FuelRepository $fuelRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fuel->getCarburantId(), $request->request->get('_token'))) {
            $fuelRepository->remove($fuel, true);
        }

        return $this->redirectToRoute('admin_cluster_fuel_index', [], Response::HTTP_SEE_OTHER);
    }
}
