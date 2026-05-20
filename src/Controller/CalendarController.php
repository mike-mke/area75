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
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/calendar')]
class CalendarController extends AbstractController
{
    #[Route('', name: 'app_calendar')]
    public function index(Request $request, EventRepository $eventRepository): Response
    {
        $year  = (int) ($request->query->get('year',  date('Y')));
        $month = (int) ($request->query->get('month', date('m')));

        // Clamp month
        if ($month < 1)  { $month = 12; $year--; }
        if ($month > 12) { $month = 1;  $year++; }

        $events   = $eventRepository->findByMonth($year, $month);
        $upcoming = $eventRepository->findUpcoming(10);

        return $this->render('calendar/index.html.twig', [
            'events'   => $events,
            'upcoming' => $upcoming,
            'year'     => $year,
            'month'    => $month,
            'prevYear'  => $month === 1 ? $year - 1 : $year,
            'prevMonth' => $month === 1 ? 12 : $month - 1,
            'nextYear'  => $month === 12 ? $year + 1 : $year,
            'nextMonth' => $month === 12 ? 1 : $month + 1,
        ]);
    }

    #[Route('/add', name: 'app_calendar_add')]
    #[IsGranted('ROLE_USER')]
    public function add(
        Request $request,
        EventRepository $eventRepository,
        SluggerInterface $slugger,
        EntityManagerInterface $em
    ): Response {
        $event = new Event();
        $form  = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle PDF upload
            $flyerFile = $form->get('flyerFile')->getData();
            if ($flyerFile) {
                $originalFilename = pathinfo($flyerFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename  = $safeFilename . '-' . uniqid() . '.pdf';
                $uploadDir = $this->getParameter('upload_dir');
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $flyerFile->move($uploadDir, $newFilename);
                $event->setFlyerPath($newFilename);
            }

            $event->setCreatedBy($this->getUser());
            $event->setIsApproved(false); // requires admin approval

            $em->persist($event);
            $em->flush();

            $this->addFlash('success', 'Your event has been submitted and is awaiting approval. Thank you!');
            return $this->redirectToRoute('app_calendar');
        }

        return $this->render('calendar/add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/event/{id}', name: 'app_event_show')]
    public function show(int $id, EventRepository $eventRepository): Response
    {
        $event = $eventRepository->find($id);
        if (!$event || !$event->isApproved()) {
            throw $this->createNotFoundException('Event not found.');
        }

        return $this->render('calendar/show.html.twig', [
            'event' => $event,
        ]);
    }
}
