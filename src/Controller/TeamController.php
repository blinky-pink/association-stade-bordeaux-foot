<?php

namespace App\Controller;

use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TeamController extends AbstractController
{
    // Liste toutes les équipes
    #[Route('/teams', name: 'team_list')]
    public function index(TeamRepository $teamRepository): Response
    {
        $teams = $teamRepository->findAll();

        return $this->render('team/index.html.twig', [
            'teams' => $teams,
        ]);
    }

    // Affiche le détail d'une équipe avec ses joueurs
    #[Route('/team/{id}', name: 'team_show')]
    public function show(int $id, TeamRepository $teamRepository): Response
    {
        $team = $teamRepository->find($id);

        if (!$team) {
            throw $this->createNotFoundException('Équipe introuvable');
        }

        return $this->render('team/show.html.twig', [
            'team' => $team,
        ]);
    }
}