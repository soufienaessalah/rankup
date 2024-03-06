<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OfficeController extends AbstractController
{
    #[Route('/o', name: 'app_office')]
    public function index(): Response
    {
        return $this->render('admin.html.twig', [
            'controller_name' => 'OfficeController',
        ]);
    }
}
