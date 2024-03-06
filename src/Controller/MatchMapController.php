<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatchMapController extends AbstractController
{
    #[Route('/map', name: 'app_match_map')]
    public function index(): Response
    {
        return $this->render('match_map/index.html.twig', [
            'controller_name' => 'MatchMapController',
        ]);
    }
}
