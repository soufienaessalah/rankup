<?php

namespace App\Controller;


use App\Entity\Lecon;

use App\Form\LeconType;
use App\Repository\LeconRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/lecon')]
class LeconController extends AbstractController
{
    #[Route('/', name: 'app_lecon_index', methods: ['GET'])]
    public function index(LeconRepository $leconRepository): Response
    {
        return $this->render('lecon/index.html.twig', [
            'lecons' => $leconRepository->findAll(),
        ]);
    }
    

    #[Route('/new', name: 'app_lecon_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lecon = new Lecon();
        $form = $this->createForm(LeconType::class, $lecon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($lecon);
            $entityManager->flush();

            return $this->redirectToRoute('app_lecon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lecon/new.html.twig', [
            'lecon' => $lecon,
            'form' => $form,
        ]);
    }
  

    #[Route('/{id}', name: 'app_lecon_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Lecon $lecon): Response
    {
        return $this->render('lecon/show.html.twig', [
            'lecon' => $lecon,
        ]);
    }
    #[Route('/all-lecons', name: 'all_lecons', methods: ['GET'])]
 function allLecons(LeconRepository $leconRepository, PaginatorInterface $paginator, Request $request): Response
{
    $query = $leconRepository->createQueryBuilder('l')
        ->getQuery();

    $pagination = $paginator->paginate(
        $query, // Ne pas utiliser $lecons ici
        $request->query->getInt('page', 1),
        3
    );

    return $this->render('lecon/all_lecons.html.twig', [
        'lecon' => $pagination,
    ]);
}

    #[Route('/{id}/edit', name: 'app_lecon_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lecon $lecon, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LeconType::class, $lecon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_lecon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lecon/edit.html.twig', [
            'lecon' => $lecon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lecon_delete', methods: ['POST'])]
    public function delete(Request $request, Lecon $lecon, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lecon->getId(), $request->request->get('_token'))) {
            $entityManager->remove($lecon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_lecon_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/statsleconparcategorie', name: 'stats_lecon_par_categorie')]
    public function statistiquesLecon(LeconRepository $leconRepository)
    {
        // Récupérer toutes les leçons
        $lecons = $leconRepository->findAll();
    
        $leconNames = [];
        $leconCount = [];
    
        // Démontez les données pour les séparer comme attendu par ChartJS
        foreach ($lecons as $lecon) {
            $leconNames[] = $lecon->getNomLecon();
            $leconCount[] = $lecon->getPrix(); // Utilisez l'attribut que vous souhaitez pour le comptage
        }
    
        // Vous pouvez ajouter d'autres attributs selon vos besoins
    
        return $this->render('stat/stats_lecon_par_categorie.html.twig', [
            'leconNames' => json_encode($leconNames),
            'leconCount' => json_encode($leconCount),
        ]);
}
#[Route("/generate-pdf/{id}", name: "generate_pdf", methods: ['GET'])]
public function pdf($id,leconRepository $repository): Response{

    $lecon=$repository->find($id);
    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial');
    $dompdf = new Dompdf($pdfOptions);
    $html = $this->renderView('lecon/pdf.html.twig', [
        'pdf' => $lecon,

    ]);
    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $pdfOutput = $dompdf->output();
    return new Response($pdfOutput, 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="lecon.pdf"'
    ]);
}
}