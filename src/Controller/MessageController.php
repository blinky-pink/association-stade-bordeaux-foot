<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MessageController extends AbstractController
{
    // Liste tous les messages
    #[Route('/messages', name: 'message_list')]
    public function index(MessageRepository $messageRepository): Response
    {
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

    // Créer un nouveau message
    #[Route('/messages/create', name: 'message_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $message = new Message();
        // Date d'envoi automatique
        $message->setSendAt(new \DateTime());

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('message_list');
        }

        return $this->render('message/create.html.twig', [
            'form' => $form,
        ]);
    }

    // Modifier un message existant
    #[Route('/messages/edit/{id}', name: 'message_edit')]
    public function edit(int $id, Request $request, MessageRepository $messageRepository, EntityManagerInterface $em): Response
    {
        $message = $messageRepository->find($id);

        if (!$message) {
            throw $this->createNotFoundException('Message introuvable');
        }

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('message_list');
        }

        return $this->render('message/edit.html.twig', [
            'form' => $form,
            'message' => $message,
        ]);
    }

    // Supprimer un message
    #[Route('/messages/delete/{id}', name: 'message_delete')]
    public function delete(int $id, MessageRepository $messageRepository, EntityManagerInterface $em): Response
    {
        $message = $messageRepository->find($id);

        if (!$message) {
            throw $this->createNotFoundException('Message introuvable');
        }

        $em->remove($message);
        $em->flush();

        return $this->redirectToRoute('message_list');
    }
}
