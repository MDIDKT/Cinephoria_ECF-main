<?php

namespace App\Controller;

use App\Entity\Films;
use App\Repository\FilmsRepository;
use Doctrine\DBAL\Exception\TableNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(FilmsRepository $filmsRepository): Response
    {
        try {
            $films = $filmsRepository->findAll();
            return $this->render('home/index.html.twig', [
                'films' => $films,
            ]);
        } catch (TableNotFoundException $e) {
            return new Response('Table "films" not found.', 500);
        }
    }

    #[Route('/films/{id}', name: 'app_home_show', methods: ['GET'])]
    public function show(Films $film): Response
    {
        return $this->render('films/show.html.twig', [
            'film' => $film,
        ]);
    }
}
