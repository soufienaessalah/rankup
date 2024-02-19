<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProfileController extends AbstractController
{
    #[Route('/edit', name: 'profile_edit')]
    public function edit(Request $request): Response
{
    $user = $this->getUser();
    $form = $this->createForm(ProfileFormType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Handle file upload
        $photoFile = $form->get('photo')->getData();

        if ($photoFile instanceof UploadedFile) { // If a new photo is uploaded
            // Process and save the new photo as you did before
            // Generate a unique name for the file before saving it
            $newFilename = uniqid().'.'.$photoFile->guessExtension();

            // Move the file to the directory where profile photos are stored
            try {
                $photoFile->move(
                    $this->getParameter('profile_photos_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // Handle file upload error
                // e.g., log the error message or display a user-friendly message
            }

            // Update the user's profile photo property with the filename
            $user->setPhoto($newFilename);
        } elseif (!$photoFile && $user->getPhoto() !== null) { // If no new photo is uploaded and existing photo is not null
            // Retain the existing photo
            $user->setPhoto($user->getPhoto());
        }

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
