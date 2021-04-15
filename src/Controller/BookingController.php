<?php



namespace App\Controller;

use App\Service\BookingService;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/booking")
 */
class BookingController extends AbstractController
{

    /**
     * @Route("/calendarAdmin", name="booking_calendar_admin", methods={"GET"})
     */
    public function calendarAdmin(BookingRepository $br): Response
    {
        /*$bookings = $br->findByDate('2021-04-01 00:00:00', '2021-04-31 00:00:00');
        foreach($bookings as $booking){
            dd(new \DateTime($booking['date']));
        }*/

        return $this->render('bundle/EasyAdminBundle/page/calendar.html.twig');
    }


    /**
     * @Route("/calendar", name="booking_calendar", methods={"GET"})
     */
    public function calendar(BookingRepository $br): Response
    {
        /*$bookings = $br->findByDate('2021-04-01 00:00:00', '2021-04-31 00:00:00');
        foreach($bookings as $booking){
            dd(new \DateTime($booking['date']));
        }*/

        return $this->render('booking/calendar.html.twig');
    }
    /**
     * @Route("/test", name="test", methods={"GET"})
     */
    public function test(BookingRepository $br): Response
    {
        $bookings = $br->findAll();
        $datas = array();
        $erreur = "";

        if ($bookings == null) {
            $erreur = "aucune donnée à afficher";
        }
        

        foreach($bookings as $key => $booking) {

            $datas[$key]['title']= $booking->getNbOfSeats();
            $dateBegin = $booking->getBeginAt();
            
            $test = $dateBegin->format('Y-m-d');
            
            $datas[$key]['start']= $test;
            dd($datas);
            $dateEnd = $booking->getEndAt();
            
            $datas[$key]['end']= $dateEnd->format('Y-m-d');
        }
        $reponse = $datas;
        
        return new JsonResponse($reponse );
    }

    /**
     * @Route("/", name="booking_index", methods={"GET"})
     */
    /*
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('booking/index.html.twig', [
            'bookings' => $bookingRepository->findAll(),
        ]);
    }
    */

    /**
     * @Route("/new", name="booking_new", methods={"GET","POST"})
     */
    public function new(Request $request, BookingService $bookingService): Response
    {
        
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            if($this->getUser()==null){
                return $this->redirectToRoute('app_login');
            }
            $user = $this->getUser();
            //$booking = $form->getData();
            
            
            $date=$booking->getDate();
            $booking->setBeginAt($date);
            $booking->setEndAt($date);
            
            $sess = $request->getSession();
            
            if($bookingService->newBooking($booking, $user)){
                $date=$booking->getDate();
                
                $dateString=$date->format('d/m/Y');
                $nbOfSeats = $booking->getNbOfSeats();
                $totalPrice = $booking->getTotalBookingPrice();
                $sess->getFlashBag()->add("ajout", "La réservation de ".$nbOfSeats." places pour un total de ".$totalPrice." € a été ajoutée pour le ".$dateString);
            } else {
                $sess->getFlashBag()->add("erreur", "Réservation impossible, plus de places disponibles pour la journée");
            }
              

            return $this->redirectToRoute('account_bookings');
        }

        
        return $this->render('booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/{id}", name="booking_show", methods={"GET"})
     */
    
    public function show(Booking $booking, BookingRepository $bookingRepository, $id): Response
    {
        $booking = $bookingRepository->findOneById($id);
        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }
    

    /**
     * @Route("/{id}/edit", name="booking_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Booking $booking): Response
    {
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('booking_index');
        }

        return $this->render('booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="booking_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Booking $booking, BookingService $bookingService): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $bookingService->deleteBooking($booking);
        }

        return $this->redirectToRoute('account_bookings');
    }
}