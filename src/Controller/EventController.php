<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    // Liste tous les événements
    #[Route('/events', name: 'event_list')]
    public function index(EventRepository $eventRepository): Response
    {
        // Récupère tous les événements depuis la base
        $events = $eventRepository->findAll();

        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
    }

    // Affiche le détail d'un événement avec ses présences
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
}