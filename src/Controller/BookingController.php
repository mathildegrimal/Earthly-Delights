<?php



namespace App\Controller;

use App\Service\BookingService;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use DateTime;
use Stripe\Checkout\Session;
use Stripe\Stripe;
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
        return $this->render('bundle/EasyAdminBundle/page/calendar.html.twig');
    }

    /**
     * @Route("/new", name="booking_new", methods={"GET","POST"})
     */
    public function new(Request $request, BookingService $bookingService): Response
    {
        
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            
            if($bookingService->seatsAvailable($booking)){
                
                $booking->setIspaid(false);
                $date=$booking->getDate();
                $booking->setBeginAt($date);
                $booking->setEndAt($date);
                $bookingService->setTotalEntryPrice($booking);
                $bookingService->setBookingRef($booking,$user);
                $bookingService->newBooking($booking, $user);

                return $this->render('booking/preview.html.twig', [
                    'booking' => $booking
                ]);
            } else {
                $sess = $request->getSession();
                $sess->getFlashBag()->add("erreur", "Réservation impossible, plus de places disponibles pour la journée");
                return $this->render('booking/new.html.twig', [
                    'booking' => $booking,
                    'form' => $form->createView(),
                ]);
            }
        }
        return $this->render('booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/confirm/{bookingRef}", name="booking_confirm")
     */
    public function confirm(Request $request, BookingService $bookingService, BookingRepository $bookingRepository,  $bookingRef): Response
    {
        $booking = $bookingRepository->findOneByBookingRef($bookingRef);
        $user = $this->getUser();
        
        $nbOfSeats = $booking->getNbOfSeats();
        $totalPrice = $booking->getTotalBookingPrice();
        
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';
        
        $booking_for_stripe[]= [
            'price_data' => [
            'currency' => 'eur',
            'unit_amount' => $bookingService->getEntryPrice(),
            'product_data' => [
                'name' => 'Réservation N°'.$booking->getBookingRef(),
                'images' => [$YOUR_DOMAIN."/uploads/entrance.jpg"],
            ],
            ],
            'quantity' => $booking->getNbOfSeats(),
        ];

        Stripe::setApiKey('sk_test_51IjM41CE0ZMoSikaUiafL9FyLNrpm2E4mSAWxZYz0F0ouDiQ3OkObZ4BOadmMRxBu17yDD0YZKYyYW6gDOtAlvlT00U2s7hpbR');
    
        $checkout_session = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [
            $booking_for_stripe
        ],
        'mode' => 'payment',
        'success_url' => $YOUR_DOMAIN . '/success.html',
        'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
        ]);

        dump($checkout_session->id);
        dd($checkout_session);

            
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