<?php

namespace App\Controller;

use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MessageController extends AbstractController
{
    // Liste tous les messages
    #[Route('/messages', name: 'message_list')]
    public function index(MessageRepository $messageRepository): Response
    {
        // Récupère tous les messages depuis la base
        $messages = $messageRepository->findAll();

        return $this->render('message/index.html.twig', [
            'messages' => $messages,
        ]);
    }

    // Affiche le détail d'un message
    #[Route('/message/{id}', name: 'message_show')]
    public function show(int $id, MessageRepository $messageRepository): Response
    {
        $message = $messageRepository->find($id);

        if (!$message) {
            throw $this->createNotFoundException('Message introuvable');
        }

        return $this->render('message/show.html.twig', [
            'message' => $message,
        ]);
    }
}