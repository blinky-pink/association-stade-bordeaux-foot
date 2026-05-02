<?php

namespace App\Controller;

use App\Repository\CoachRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CoachController extends AbstractController
{
    // Liste tous les coachs
    #[Route('/coaches', name: 'coach_list')]
    public function index(CoachRepository $coachRepository): Response
    {
        // Récupère tous les coachs depuis la base
        $coaches = $coachRepository->findAll();

        return $this->render('coach/index.html.twig', [
            'coaches' => $coaches,
        ]);
    }

    // Affiche le détail d'un coach avec ses équipes et événements
    #[Route('/coach/{id}', name: 'coach_show')]
    public function show(int $id, CoachRepository $coachRepository): Response
    {
        $coach = $coachRepository->find($id);

        if (!$coach) {
            throw $this->createNotFoundException('Coach introuvable');
        }

        return $this->render('coach/show.html.twig', [
            'coach' => $coach,
        ]);
    }
}