<?php

namespace App\Controller;

use App\Entity\Responsable;
use App\Form\ResponsableType;
use App\Repository\ResponsableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ResponsableController extends AbstractController
{
    // Liste tous les responsables
    #[Route('/responsables', name: 'responsable_list')]
    public function index(ResponsableRepository $responsableRepository): Response
    {
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

    // Créer un nouveau responsable
    #[Route('/responsables/create', name: 'responsable_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $responsable = new Responsable();
        $form = $this->createForm(ResponsableType::class, $responsable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($responsable);
            $em->flush();

            return $this->redirectToRoute('responsable_list');
        }

        return $this->render('responsable/create.html.twig', [
            'form' => $form,
        ]);
    }

    // Modifier un responsable existant
    #[Route('/responsables/edit/{id}', name: 'responsable_edit')]
    public function edit(int $id, Request $request, ResponsableRepository $responsableRepository, EntityManagerInterface $em): Response
    {
        $responsable = $responsableRepository->find($id);

        if (!$responsable) {
            throw $this->createNotFoundException('Responsable introuvable');
        }

        $form = $this->createForm(ResponsableType::class, $responsable);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('responsable_list');
        }

        return $this->render('responsable/edit.html.twig', [
            'form' => $form,
            'responsable' => $responsable,
        ]);
    }

    // Supprimer un responsable
    #[Route('/responsables/delete/{id}', name: 'responsable_delete')]
    public function delete(int $id, ResponsableRepository $responsableRepository, EntityManagerInterface $em): Response
    {
        $responsable = $responsableRepository->find($id);

        if (!$responsable) {
            throw $this->createNotFoundException('Responsable introuvable');
        }

        $em->remove($responsable);
        $em->flush();

        return $this->redirectToRoute('responsable_list');
    }
}
