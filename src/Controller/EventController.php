<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EventType;
use App\Entity\Event;
use App\Entity\Attendee;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class EventController extends AbstractController
{

    #[Route('/events', name: 'app_events')]
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findAll();
        return $this->render('events/index.html.twig', [
            'events' => $events
        ]);
    }

      /**
     * @param Event $event
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    private function save(Event $event, Request $request, EntityManagerInterface $manager): Response
    {

        // si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($event->getId() !== null) {
   
            if ($event->getUser() !== $this->getUser()) {
                throw $this->createAccessDeniedException('Vous n\'avez pas le droit de modifier cet article');
            }
        }

        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event->setUser($this->getUser())
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($event);
            $manager->flush();

            return $this->redirectToRoute('app_events');
        }

        return $this->render('events/create.html.twig', [
            'form' => $form->createView()
        ]);
}

    #[Route('events/create', name: 'app_events_create')]
    public function create(EntityManagerInterface $manager, Request $request): Response
    {
        $form = new Event();

        return $this->save($form, $request, $manager);
    }

    #[Route('events/{id}/edit', name: 'app_events_edit')]
    public function edit(Event $event, Request $request, EntityManagerInterface $manager): Response
    {
        return $this->save($event, $request, $manager);
    }

    #[Route('events/{id}', name: 'app_events_show')]
    public function show(Event $event, EntityManagerInterface $manager, Request $request): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        return $this->render('events/show.html.twig', [
            'event' => $event,
            'form' => $form->createView()
        ]);
    }

    #[Route('events/{id}/delete', name: 'app_events_delete')]
    public function delete(Event $event, EntityManagerInterface $manager): Response
    {
        $manager->remove($event);
        $manager->flush();

        return $this->redirectToRoute('app_events');
    }

    #[Route('events/{id}/join', name: 'app_events_join')]
    public function join(Event $event, EntityManagerInterface $manager): Response
    {
        $attendee = new Attendee();
        $attendee->setUser($this->getUser())
            ->addEvent($event);
        $manager->persist($attendee);
        $manager->flush();

        return $this->redirectToRoute('app_events');
    }

    #[Route('events/{id}/leave', name: 'app_events_leave')]
    public function leave(Event $event, EntityManagerInterface $manager): Response
    {
        $attendee = $event->getAttendees()->filter(function (Attendee $attendee) {
            return $attendee->getUser() === $this->getUser();
        })->first();

        $manager->remove($attendee);
        $manager->flush();

        return $this->redirectToRoute('app_events');
    }
}