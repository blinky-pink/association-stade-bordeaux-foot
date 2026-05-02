<?php

namespace App\Controller;

use App\Repository\ResponsableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ResponsableController extends AbstractController
{
    // Liste tous les responsables
    #[Route('/responsables', name: 'responsable_list')]
    public function index(ResponsableRepository $responsableRepository): Response
    {
        // Récupère tous les responsables depuis la base
        $responsables = $responsableRepository->findAll();

        return $this->render('responsable/index.html.twig', [
            'responsables' => $responsables,
        ]);
    }

    // Affiche le détail d'un responsable
    #[Route('/responsable/{id}', name: 'responsable_show')]
    public function show(int $id, ResponsableRepository $responsableRepository): Response
    {
        $responsable = $responsableRepository->find($id);

        if (!$responsable) {
            throw $this->createNotFoundException('Responsable introuvable');
        }

        return $this->render('responsable/show.html.twig', [
            'responsable' => $responsable,
        ]);
    }
}