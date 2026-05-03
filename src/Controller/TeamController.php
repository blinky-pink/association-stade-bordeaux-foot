<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    // Affiche le détail d'une équipe
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

    // Créer une nouvelle équipe
    #[Route('/teams/create', name: 'team_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($team);
            $em->flush();

            return $this->redirectToRoute('team_list');
        }

        return $this->render('team/create.html.twig', [
            'form' => $form,
        ]);
    }

    // Modifier une équipe existante
    #[Route('/teams/edit/{id}', name: 'team_edit')]
    public function edit(int $id, Request $request, TeamRepository $teamRepository, EntityManagerInterface $em): Response
    {
        $team = $teamRepository->find($id);

        if (!$team) {
            throw $this->createNotFoundException('Équipe introuvable');
        }

        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('team_list');
        }

        return $this->render('team/edit.html.twig', [
            'form' => $form,
            'team' => $team,
        ]);
    }

    // Supprimer une équipe
    #[Route('/teams/delete/{id}', name: 'team_delete')]
    public function delete(int $id, TeamRepository $teamRepository, EntityManagerInterface $em): Response
    {
        $team = $teamRepository->find($id);

        if (!$team) {
            throw $this->createNotFoundException('Équipe introuvable');
        }

        $em->remove($team);
        $em->flush();

        return $this->redirectToRoute('team_list');
    }
}