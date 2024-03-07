<?php

namespace App\Security;
use App\Repository\UserRepository;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class AppCustomAuthAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;
    private AuthorizationCheckerInterface $authorizationChecker;
    public const LOGIN_ROUTE = 'app_login';

    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        AuthorizationCheckerInterface $authorizationChecker,UserRepository $userRepository
    ) {
        $this->authorizationChecker = $authorizationChecker;
        $this->userRepository = $userRepository;
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');
        // Retrieve the user from the database based on the provided email address
        $user = $this->userRepository->findOneByEmail($email);

           // Check if the user is blocked
           if ($user->getStatus() === 'blocked') {
            throw new CustomUserMessageAuthenticationException('Your account has been blocked.');
        }

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Check if the user has ROLE_ADMIN
        if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            // Redirect to the admin page
            return new RedirectResponse($this->urlGenerator->generate('admin')); // Change 'admin_dashboard' to your actual route name
        }

        // If not an admin, proceed with default behavior
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // For example:
        // return new RedirectResponse($this->urlGenerator->generate('some_route'));
        return new RedirectResponse($this->urlGenerator->generate('app_t_t_t'));
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
