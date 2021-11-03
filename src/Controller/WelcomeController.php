<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/welcome", name="welcome")
     */
    public function welcome(): Response
    {
        return $this->render('welcome/contact.html.twig', [
            'controller_name' => 'WelcomeController',
        ]);
    }
    /**
     * @Route("/{name}", name="home", defaults={"name" = "World!"}, requirements={"name" = "[A-Za-z]+" })
     */
    public function index($name): Response
    {
        return $this->render('hello_page.html.twig', [
            'name' => $name,
            'controller_name' => 'WelcomeController',
        ]);
    }
}
