<?php
/**
 * Created by PhpStorm.
 * User: mikhail
 * Date: 14.12.18
 * Time: 7:52
 */

namespace App\Controller;



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
     * @Route("/login", name="")
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
}