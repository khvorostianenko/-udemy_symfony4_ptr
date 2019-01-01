<?php
namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController
{
    /**
     * @var \Twig_Environment
     */
    private $twig;
    
    public function __construct(\Twig_Environment $twig_Environment)
    {
        $this->twig = $twig_Environment;
    }
    
    /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        return new Response($this->twig->render(
            'security/login.html.twig',
            [
                'last_username' => $authenticationUtils->getLastUsername(),
                'error' => $authenticationUtils->getLastAuthenticationError(),
            ]
        ));
    }
    
    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {
        
    }
    
    /**
     * @Route("/confirm/{token}", name="security_confirm")
     */
    public function confirm(
        string $token, 
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ) {
        /** @var User $user */
        $user = $userRepository->findOneBy(
            ['confirmationToken' => $token]
        );
        
        if ($user !== null) {
            $user->setEnabled(true);
            $user->setConfirmationToken('');
    
            /* persist не нужен, так как сам юзер уже есть */
            $entityManager->flush();
        }
        
        return new Response(
            $this->twig->render(
                'security/confirmation.html.twig', 
                ['user' => $user]
            )
        );
    }
}