<?php

namespace App\Controller;

use App\Entity\SubscriptionPlan;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
