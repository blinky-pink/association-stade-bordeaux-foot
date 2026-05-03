<?php

namespace App\Controller;

use App\Repository\TeamRepository;
use App\Repository\PlayerRepository;
use App\Repository\EventRepository;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function index(
        TeamRepository $teamRepository,
        PlayerRepository $playerRepository,
        EventRepository $eventRepository,
        MessageRepository $messageRepository
    ): Response
    {
        return $this->render('dashboard/index.html.twig', [
            // Nombre total de chaque entité
            'nbTeams'    => count($teamRepository->findAll()),
            'nbPlayers'  => count($playerRepository->findAll()),
            'nbEvents'   => count($eventRepository->findAll()),
            'nbMessages' => count($messageRepository->findAll()),

            // Les 3 derniers événements
            'lastEvents' => $eventRepository->findBy([], ['id' => 'DESC'], 3),
        ]);
    }
}