<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Player;
use App\Entity\Event;
use App\Entity\Presence;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AttendanceController extends AbstractController
{
    #[Route('/team/{id}/attendance/{eventId}', name: 'team_attendance')]
    public function index(Team $team, int $eventId, EntityManagerInterface $em): Response
    {
        $event = $em->getRepository(Event::class)->find($eventId);
        
        if (!$event) {
            throw $this->createNotFoundException();
        }
        $presences = $em->getRepository(Presence::class)->findBy([
            'event' => $event
        ]);

        return $this->render('attendance/index.html.twig', [
            'team' => $team,
            'players' => $team->getPlayers(),
            'presences' => $presences,
            'event' => $event,
        ]);
    }

    #[Route('/presence/{playerId}/{eventId}/{status}', name: 'save_presence')]
    public function save(
        int $playerId,
        int $eventId,
        string $status,
        EntityManagerInterface $em
    ): Response {
        $player = $em->getRepository(Player::class)->find($playerId);
        $event = $em->getRepository(Event::class)->find($eventId);

        if (!$player || !$event) {
            throw $this->createNotFoundException();
        }

        //--- Cherche si déjà une présence existe
        $presence = $em->getRepository(Presence::class)->findOneBy([
            'player' => $player,
            'event' => $event,
        ]);

        //--- Si aucune → on crée
        if (!$presence) {
            $presence = new Presence();
            $presence->setPlayer($player);
            $presence->setEvent($event);
        }

        //--- Mise à jour du statut
        $presence->setStatus($status);
        $presence->setDate(new \DateTime());

        $em->persist($presence);
        $em->flush();

        return $this->redirectToRoute('team_attendance', [
            'id' => $player->getTeam()->getId(),
            'eventId' => $event->getid(),
        ]);
    }
}