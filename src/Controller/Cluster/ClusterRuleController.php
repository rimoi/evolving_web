<?php

declare(strict_types=1);

namespace App\Controller\Cluster;

use App\Entity\Cluster\ClusterRule;
use App\Form\Cluster\ClusterRuleType;
use App\Repository\Cluster\ClusterRuleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/cluster/rule', name: 'admin_cluster_rule_')]
class ClusterRuleController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ClusterRuleRepository $clusterRuleRepository): Response
    {
        return $this->render('cluster/cluster_rule/index.html.twig', [
            'cluster_rules' => $clusterRuleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, ClusterRuleRepository $clusterRuleRepository): Response
    {
        $clusterRule = new ClusterRule();
        $form = $this->createForm(ClusterRuleType::class, $clusterRule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clusterRuleRepository->add($clusterRule, true);

            return $this->redirectToRoute('admin_cluster_rule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cluster/cluster_rule/new.html.twig', [
            'cluster_rule' => $clusterRule,
            'form' => $form,
        ]);
    }

    #[Route('/{cluster}/show', name: 'show', methods: ['GET'])]
    public function show(ClusterRule $clusterRule): Response
    {
        return $this->render('cluster/cluster_rule/show.html.twig', [
            'cluster_rule' => $clusterRule,
        ]);
    }

    #[Route('/{cluster}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ClusterRule $clusterRule, ClusterRuleRepository $clusterRuleRepository): Response
    {
        $form = $this->createForm(ClusterRuleType::class, $clusterRule, ['edition' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clusterRuleRepository->add($clusterRule, true);

            return $this->redirectToRoute('admin_cluster_rule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cluster/cluster_rule/edit.html.twig', [
            'cluster_rule' => $clusterRule,
            'form' => $form,
        ]);
    }

    #[Route('/{cluster}', name: 'admin_cluster_rule_delete', methods: ['POST'])]
    public function delete(Request $request, ClusterRule $clusterRule, ClusterRuleRepository $clusterRuleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$clusterRule->getCluster(), $request->request->get('_token'))) {
            $clusterRuleRepository->remove($clusterRule, true);
        }

        return $this->redirectToRoute('admin_cluster_rule_index', [], Response::HTTP_SEE_OTHER);
    }
}
