<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
   
     #[Route('/edit', name: 'profile_edit')]
          public function edit(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('profile_show');
        }

        return $this->render('edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/show', name: 'profile_show')]
    public function show(): Response
    {
        $user = $this->getUser();

        return $this->render('show.html.twig', [
            'user' => $user,
        ]);
    }
}
