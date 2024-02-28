<?php

namespace App\Controller;

use App\Entity\User;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Response;

class GoogleController extends AbstractController
{
    #[Route("/connect/google", name: "connect_google")]
    public function connectAction(ClientRegistry $clientRegistry): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        return $clientRegistry
            ->getClient('google')
            ->redirect();
    }

    #[Route("/connect/google/check", name: "connect_google_check")]
    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry): Response
    {
        $code = $request->query->get('code');

        // Get the access token using the authorization code
        $googleClient = $clientRegistry->getClient('google');
        $accessToken = $googleClient->getAccessToken(['code' => $code]);

        // Fetch user details from Google using the access token
        $googleUser = $googleClient->fetchUserFromToken($accessToken);

        // Check if the user is already registered
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $googleUser->getEmail()]);

        if (!$user) {
            // User is not registered, create a new User entity
            $user = new User();
            $user->setEmail($googleUser->getEmail());
            $user->setUsername($googleUser->getName()); // Use name as the username
            $user->setRoles(['ROLE_USER']); // Assign the role ROLE_USER to the user

            // Persist the new user
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // Log in the user programmatically
            $this->authenticateUser($user);

            return $this->redirectToRoute('app_t_t_t');
        }
        $this->authenticateUser($user);
        return $this->redirectToRoute('app_t_t_t');
    }

    private function authenticateUser(UserInterface $user): void
    {
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->get('security.token_storage')->setToken($token);
    }
}
