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
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\Dompdf;


use Dompdf\Options;


#[Route('/suivi/reclamation')]
class SuiviReclamationController extends AbstractController
{
    #[Route('/', name: 'app_suivi_reclamation_index', methods: ['GET'])]
    public function index(SuiviReclamationRepository $suiviReclamationRepository , Request $request, PaginatorInterface $paginator): Response
    {

        // Correction : initialisation de la variable $suivi_reclamations
    $suivi_reclamations = $suiviReclamationRepository->findAll();

    $suivi_reclamations = $paginator->paginate(
        $suivi_reclamations, /* query NOT result */
        $request->query->getInt('page', 1),  2 );

    return $this->render('suivi_reclamation/index.html.twig', [
        'suivi_reclamations' => $suivi_reclamations,
    ]);
    }

    #[Route('/new', name: 'app_suivi_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $suiviReclamation = new SuiviReclamation();

// Récupération des paramètres de la réclamation depuis la requête
$reclamationId = $request->query->get('reclamation_id');
$reclamationDescription = $request->query->get('reclamation_description');

// Pré-remplissage des champs du formulaire avec les informations de la réclamation
$suiviReclamation->setIdRec($reclamationId);
if ($reclamationDescription !== null) {
    $suiviReclamation->setDescription($reclamationDescription);
}





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
    #[Route('/orderByDate', name: 'app_suivi_reclamation_order_by_date', methods: ['GET'])]

    public function orderByDate(SuiviReclamationRepository $suiviReclamationRepository, Request $request, PaginatorInterface $paginator): Response
    {
        // Récupérer la liste des suivis de réclamation triés par date
        $suiviReclamations = $suiviReclamationRepository->orderByDate();
    
        $suivi_reclamations = $paginator->paginate(
            $suiviReclamations, /* query NOT result */
            $request->query->getInt('page', 1), // Numéro de la page
            5 // Nombre d'éléments par page
);
    
        return $this->render('suivi_reclamation/index.html.twig', [
            'suivi_reclamations' => $suivi_reclamations,
        ]);
    }



    
    #[Route("/generate-pdf/{id}", name: "generate_pdf", methods: ['GET'])]
    public function pdf($id,SuiviReclamationRepository $suiviReclamationRepository): Response{
    
        $suivi_reclamations = $suiviReclamationRepository->find($id);
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('suivi_reclamation/pdf.html.twig', [
            'pdf' =>  $suivi_reclamations,
    
        ]);
        $dompdf->loadHtml($html);
    
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        $pdfOutput = $dompdf->output();
        return new Response($pdfOutput, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="suivi_reclamation.pdf"'
        ]);
    }





}
