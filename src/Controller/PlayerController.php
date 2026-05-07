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
use Symfony\Component\String\Slugger\SluggerInterface;

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
    public function create(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Gestion de la photo
            $photoFile = $form->get('photoFile')->getData();
            if ($photoFile) {
                $newFilename = uniqid() . '.' . $photoFile->guessExtension();
                $photoFile->move(
                    $this->getParameter('photos_directory'),
                    $newFilename
                );
                $player->setPhoto($newFilename);
            }

            $em->persist($player);
            $em->flush();

            return $this->redirectToRoute('player_list');
        }

        return $this->render('player/create.html.twig', [
            'form' => $form,
        ]);
    }

    // Modifier un joueur existant
    #[Route('/players/edit/{id}', name: 'player_edit')]
    public function edit(int $id, Request $request, PlayerRepository $playerRepository, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $player = $playerRepository->find($id);

        if (!$player) {
            throw $this->createNotFoundException('Joueur introuvable');
        }

        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Gestion de la photo
            $photoFile = $form->get('photoFile')->getData();
            if ($photoFile) {
                $newFilename = uniqid() . '.' . $photoFile->guessExtension();
                $photoFile->move(
                    $this->getParameter('photos_directory'),
                    $newFilename
                );
                $player->setPhoto($newFilename);
            }

            $em->flush();

            return $this->redirectToRoute('player_list');
        }

        return $this->render('player/edit.html.twig', [
            'form' => $form,
            'player' => $player,
        ]);
    }

    // Supprimer un joueur
    #[Route('/players/delete/{id}', name: 'player_delete')]
    public function delete(int $id, PlayerRepository $playerRepository, EntityManagerInterface $em): Response
    {
        $player = $playerRepository->find($id);

        if (!$player) {
            throw $this->createNotFoundException('Joueur introuvable');
        }

        // Supprime d'abord les présences liées au joueur
        foreach ($player->getPresences() as $presence) {
            $em->remove($presence);
        }

        // Supprime le joueur de la base
        $em->remove($player);
        $em->flush();
        
        return $this->redirectToRoute('player_list');
    }

    #[Route('/player/{id}/photo', name: 'player_photo_upload', methods: ['POST'])]
    public function uploadPhoto(int $id, Request $request, PlayerRepository $playerRepository, EntityManagerInterface $em): Response
    {
        $player = $playerRepository->find($id);

        if (!$player) {
            throw $this->createNotFoundException('Joueur introuvable');
        }

        $photoFile = $request->files->get('photoFile');

        if ($photoFile) {
            $mimeType = $photoFile->getMimeType();
            $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];

            if (in_array($mimeType, $allowedMimes) && $photoFile->getSize() <= 2 * 1024 * 1024) {
                $newFilename = uniqid() . '.' . $photoFile->guessExtension();
                $photoFile->move(
                    $this->getParameter('photos_directory'),
                    $newFilename
                );
                $player->setPhoto($newFilename);
                $em->flush();
            }
        }

        return $this->redirectToRoute('player_show', ['id' => $id]);
    }
}