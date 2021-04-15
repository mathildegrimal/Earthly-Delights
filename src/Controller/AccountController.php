<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/compte")
 */
class AccountController extends AbstractController
{

    /**
     * @Route("/", name="account")
     */
    
    public function index(): Response
    {
        return $this->render('account/index.html.twig', [
        ]);
    }
    /**
     * @Route("/reservations", name="account_bookings")
     */
    public function showBookings(): Response
    {
        $user = $this->getUser();
        $bookings = $user->getBookings()->toArray();
        
        return $this->render('account/bookings.html.twig', [
            'bookings'=>$bookings
        ]);
    }
}
