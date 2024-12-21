<?php

namespace App\Controller;

use App\Entity\Films;
use App\Repository\FilmsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{

    /*#[Route('/films/{id}', name: 'app_home_show', methods: ['GET'])]
    public function show (Films $film): Response
    {
        return $this->render ('films/show.html.twig', [
            'film' => $film,
        ]);
    }*/
}
