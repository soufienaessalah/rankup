<?php

namespace App\Controller;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        // Check if the user is blocked
        $user = $this->getUser();
        if ($user && $user->getStatus() == 'blocked') {
            throw new CustomUserMessageAuthenticationException('Your account has been blocked.');
        }





        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


    #[Route('/admin', name: 'admin')]
    public function index1(): Response
    {     $userRepository = $this->getDoctrine()->getRepository(User::class);
        $users = $userRepository->findAll();
        return $this->render('security/admin.html.twig', [
            'controller_name' => 'SecurityController',
                'user' => $this->getUser(),'users' => $users,
        ]);
    }
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): RedirectResponse 

    {
        return new RedirectResponse($this->generateUrl('app_t_t_t'));
    }
    #[Route('/user/{id}/edit', name: 'adminedituser')]
    public function edit(Request $request, $id): Response 
    {
        // Retrieve the user entity from the database based on the provided ID
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        // Check if the user exists
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        // Handle form submission if the request is POST
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the updated user entity to the database
            $entityManager->flush();

            // Redirect to a success page or render a success message
            return $this->redirectToRoute('admin');
        }

        // Render the form template with the user entity
        return $this->render('security/editadmin.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
