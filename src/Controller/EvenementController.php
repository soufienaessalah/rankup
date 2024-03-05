<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;




#[Route('/evenement')]
class EvenementController extends AbstractController
{




    #[Route('/indexmain', name: 'indewmain', methods: ['GET'])]
    public function indexmain(EvenementRepository $evenementRepository): Response
    {
        $events =  $evenementRepository->findAll();

        $eventsArray = [];

        foreach ($events as $event) {
            $eventsArray[] = [
                'id' => $event->getId(),
                'start' => $event->getDateDebut()->format('Y-m-d'),
                'title' => "event" . $event->getNomEvent()
            ];
        }

        $data = json_encode($eventsArray);

        return $this->render('evenement/maincalander.html.twig', ['data' => $data]);
    }

    #[Route('/', name: 'app_evenement_index', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository, PaginatorInterface $paginator, Request $request): Response
    {

        //$query = $evenementRepository->createQueryBuilder('e')->getQuery();
        $data = $evenementRepository->findAll();


        $evenements = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1),
            4 // Number of items per page
        );

        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements,
        ]);
    }

    #[Route('/affichageA', name: 'app_evenement_affichageA', methods: ['GET'])]
    public function affichageA(EvenementRepository $evenementRepository): Response
    {
        return $this->render('evenement/affichageA.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_affichageA', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $evenement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_affichageA', [], Response::HTTP_SEE_OTHER);
    }





    #[Route("/generate-pdf/{id}", name: "generate_pdf", methods: ['GET'])]
    #[ParamConverter("evenement", class: "App\Entity\Evenement")]
    public function generatePdf($id, EvenementRepository $evenementRepository, \Dompdf\Dompdf $dompdf): Response
    {
        // Get the subscription plan details
        $evenement = $evenementRepository->find($id);

        // Create Dompdf instance
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        //$dompdf = new Dompdf($pdfOptions);

        // Render the Twig template to HTML
        $html = $this->renderView('pdfEevenet.html.twig', [
            'evenement' => $evenement,
        ]);

        // Load HTML content into Dompdf
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF
        $dompdf->render();

        // Output PDF content
        $pdfOutput = $dompdf->output();

        // Send the PDF as a response
        return new Response($pdfOutput, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="event.pdf"'
        ]);
    }
}
