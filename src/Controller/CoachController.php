<?php

namespace App\Controller;

use App\Entity\Coach;
use App\Form\CoachType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    // Créer un nouveau coach
    #[Route('/coaches/create', name: 'coach_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $coach = new Coach();
        $form = $this->createForm(CoachType::class, $coach);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($coach);
            $em->flush();

            return $this->redirectToRoute('coach_list');
        }

        return $this->render('coach/create.html.twig', [
            'form' => $form,
        ]);
    }

    // Modifier un coach existant
    #[Route('/coaches/edit/{id}', name: 'coach_edit')]
    public function edit(int $id, Request $request, CoachRepository $coachRepository, EntityManagerInterface $em): Response
    {
        $coach = $coachRepository->find($id);

        if (!$coach) {
            throw $this->createNotFoundException('Coach introuvable');
        }

        $form = $this->createForm(CoachType::class, $coach);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('coach_list');
        }

        return $this->render('coach/edit.html.twig', [
            'form' => $form,
            'coach' => $coach,
        ]);
    }

    // Supprimer un coach
    #[Route('/coaches/delete/{id}', name: 'coach_delete')]
    public function delete(int $id, CoachRepository $coachRepository, EntityManagerInterface $em): Response
    {
        $coach = $coachRepository->find($id);

        if (!$coach) {
            throw $this->createNotFoundException('Coach introuvable');
        }

        $em->remove($coach);
        $em->flush();

        return $this->redirectToRoute('coach_list');
    }
}
