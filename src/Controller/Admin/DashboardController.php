<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use App\Entity\Park;
use App\Entity\Attraction;
use App\Entity\User;

use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('User App');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('User', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Attraction', 'fas fa-gamepad', Attraction::class);
        yield MenuItem::linkToCrud('Park', 'fas fa-parachute-box', Park::class);
        yield MenuItem::linkToCrud('Booking', 'fas fa-list', Booking::class);
        yield MenuItem::linkToRoute('Calendar', 'far fa-calendar', 'booking_calendar_admin');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
        ->addCssFile('css/admin.css')
        ->addCssFile('https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.1.0/main.min.css')
        ->addCssFile('https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@4.1.0/main.min.css')
        ->addCssFile('https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@4.1.0/main.min.css')
        
        ->addJsFile('assets/js/calendar.js')
        ->addJsFile('https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.1.0/main.min.js')
        ->addJsFile('https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@4.1.0/main.min.js')
        ->addJsFile('https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@4.1.0/main.min.js')
        ->addJsFile('https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@4.1.0/main.min.js');

    }
}
