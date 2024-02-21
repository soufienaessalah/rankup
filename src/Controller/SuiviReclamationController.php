<?php

namespace App\Controller;

use App\Entity\SuiviReclamation;
use App\Form\SuiviReclamationType;
use App\Repository\SuiviReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/suivi/reclamation')]
class SuiviReclamationController extends AbstractController
{
    #[Route('/', name: 'app_suivi_reclamation_index', methods: ['GET'])]
    public function index(SuiviReclamationRepository $suiviReclamationRepository): Response
    {
        return $this->render('suivi_reclamation/index.html.twig', [
            'suivi_reclamations' => $suiviReclamationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_suivi_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $suiviReclamation = new SuiviReclamation();
        $form = $this->createForm(SuiviReclamationType::class, $suiviReclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($suiviReclamation);
            $entityManager->flush();

            return $this->redirectToRoute('app_suivi_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('suivi_reclamation/new.html.twig', [
            'suivi_reclamation' => $suiviReclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_suivi_reclamation_show', methods: ['GET'])]
    public function show(SuiviReclamation $suiviReclamation): Response
    {
        return $this->render('suivi_reclamation/show.html.twig', [
            'suivi_reclamation' => $suiviReclamation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_suivi_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SuiviReclamation $suiviReclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SuiviReclamationType::class, $suiviReclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_suivi_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('suivi_reclamation/edit.html.twig', [
            'suivi_reclamation' => $suiviReclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_suivi_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, SuiviReclamation $suiviReclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$suiviReclamation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($suiviReclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_suivi_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
}
