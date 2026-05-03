<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    // Liste tous les événements
    #[Route('/events', name: 'event_list')]
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findAll();

        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
    }

    // Affiche le détail d'un événement
    #[Route('/event/{id}', name: 'event_show')]
    public function show(int $id, EventRepository $eventRepository): Response
    {
        $event = $eventRepository->find($id);

        if (!$event) {
            throw $this->createNotFoundException('Événement introuvable');
        }

        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    // Créer un nouvel événement
    #[Route('/events/create', name: 'event_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('event_list');
        }

        return $this->render('event/create.html.twig', [
            'form' => $form,
        ]);
    }

    // Modifier un événement existant
    #[Route('/events/edit/{id}', name: 'event_edit')]
    public function edit(int $id, Request $request, EventRepository $eventRepository, EntityManagerInterface $em): Response
    {
        $event = $eventRepository->find($id);

        if (!$event) {
            throw $this->createNotFoundException('Événement introuvable');
        }

        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('event_list');
        }

        return $this->render('event/edit.html.twig', [
            'form' => $form,
            'event' => $event,
        ]);
    }

    // Supprimer un événement
    #[Route('/events/delete/{id}', name: 'event_delete')]
    public function delete(int $id, EventRepository $eventRepository, EntityManagerInterface $em): Response
    {
        $event = $eventRepository->find($id);

        if (!$event) {
            throw $this->createNotFoundException('Événement introuvable');
        }

        // Supprime d'abord les présences liées à l'événement
        foreach ($event->getPresences() as $presence) {
            $em->remove($presence);
        }

        $em->remove($event);
        $em->flush();

        return $this->redirectToRoute('event_list');
    }
}
