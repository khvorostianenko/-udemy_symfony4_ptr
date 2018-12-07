<?php
/**
 * Created by PhpStorm.
 * User: mikhail
 * Date: 05.12.18
 * Time: 8:13
 */

namespace App\Controller;

use App\Service\Greeting;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class BlogController
{
    /**
     * @var Greeting
     */
    private $greeting;
    /**
     * @var \Twig_Environment
     */
    private $twig;
    
    public function __construct(Greeting $greeting, \Twig_Environment $twig)
    {
        $this->greeting = $greeting;
        $this->twig = $twig;
    }
    
    /**
     * @Route("/{name}", name="blog_index")
     */
    public function index($name)
    {
        $html = $this->twig->render('base.html.twig', ['message' => $this->greeting->greet($name)]);
        
        return new Response($html);
    }
}