<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="home_front")
     * @Route("/{route}", name="pages_front", requirements={"route"="^(?!api).+"})
     * @return Response
     */
    public function index(): Response 
    {
        return $this->render('front.html.twig', []);
    }
}