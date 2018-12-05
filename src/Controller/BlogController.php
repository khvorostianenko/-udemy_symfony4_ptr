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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends AbstractController
{
    /**
     * @var Greeting
     */
    private $greeting;
    
    public function __construct(Greeting $greeting)
    {
        $this->greeting = $greeting;
    }
    
    /**
     * @Route("/", name="blog_index")
     */
    public function index(Request $request)
    {
        return $this->render('base.html.twig', ['message' => $this->greeting->greet($request->get('name'))]);
    }
}