<?php

namespace App\Controller;

use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlayerController extends AbstractController
{
    // Liste tous les joueurs
    #[Route('/players', name: 'player_list')]
    public function index(PlayerRepository $playerRepository): Response
    {
        // Récupère tous les joueurs depuis la base
        $players = $playerRepository->findAll();

        return $this->render('player/index.html.twig', [
            'players' => $players,
        ]);
    }

    // Affiche le détail d'un joueur
    #[Route('/player/{id}', name: 'player_show')]
    public function show(int $id, PlayerRepository $playerRepository): Response
    {
        $player = $playerRepository->find($id);

        if (!$player) {
            throw $this->createNotFoundException('Joueur introuvable');
        }

        return $this->render('player/show.html.twig', [
            'player' => $player,
        ]);
    }
}