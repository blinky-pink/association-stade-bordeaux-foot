<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlayerController extends AbstractController
{
    // Liste tous les joueurs
    #[Route('/players', name: 'player_list')]
    public function index(PlayerRepository $playerRepository): Response
    {
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

    // Créer un nouveau joueur
    #[Route('/players/create', name: 'player_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        // Crée un joueur vide
        $player = new Player();

        // Crée le formulaire lié au joueur
        $form = $this->createForm(PlayerType::class, $player);

        // Analyse la requête HTTP (données du formulaire soumis)
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Prépare et enregistre en base
            $em->persist($player);
            $em->flush();

            // Redirige vers la liste des joueurs
            return $this->redirectToRoute('player_list');
        }

        return $this->render('player/create.html.twig', [
            'form' => $form,
        ]);
    }
}