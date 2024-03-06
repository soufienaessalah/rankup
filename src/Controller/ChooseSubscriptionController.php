<?php

namespace App\Controller;

use App\Entity\SubscriptionPlan;
use App\Repository\SubscriptionPlanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;


class ChooseSubscriptionController extends AbstractController
{
    #[Route('/choose/subscription', name: 'app_choose_subscription')]
    public function index(): Response
    {
        // Get the EntityManager
        $entityManager = $this->getDoctrine()->getManager();

        // Retrieve all subscription plans from the database
        $subscriptionPlans = $entityManager->getRepository(SubscriptionPlan::class)->findAll();

        // Render the Twig template with the subscription plans
        return $this->render('choose_subscription/index.html.twig', [
            'subscriptionPlans' => $subscriptionPlans,
        ]);
    }

    #[Route('/subscription/plan/{id}/details', name: 'app_choose_subscription_details', methods: ['GET'])]
    public function details(SubscriptionPlan $subscriptionPlan): Response
    {
        return $this->render('choose_subscription/details.html.twig', [
            'subscription_plan' => $subscriptionPlan,
        ]);
    }

    #[Route ("/generate-pdf/{id}", name: "generate_pdf", methods: ['GET'])]
    public function generatePdf($id, SubscriptionPlanRepository $subscriptionPlanRepository): Response
    {
        // Get the subscription plan details
        $subscriptionPlan = $subscriptionPlanRepository->find($id);
        
        // Create Dompdf instance
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        
        // Render the Twig template to HTML
        $html = $this->renderView('choose_subscription/pdf.html.twig', [
            'subscription_plan' => $subscriptionPlan,
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
            'Content-Disposition' => 'attachment; filename="subscription_plan.pdf"'
        ]);
    }

    
}
