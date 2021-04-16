<?php

namespace App\EventSubscriber;

use App\Repository\BookingRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;





class CalendarSubscriber implements EventSubscriberInterface
{
    private $bookingRepository;
    private $router;

    public function __construct(
        BookingRepository $bookingRepository,
        UrlGeneratorInterface $router
    ) {
        $this->bookingRepository = $bookingRepository;
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }
    

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change booking.beginAt by your start date property
        

        $bookings = $this->bookingRepository
            ->createQueryBuilder('b')
            ->select(array('sum(b.nbOfSeats) as seats','b.date','b.beginAt','b.endAt'))
            ->where('b.date > :value1')
            ->andWhere('b.date < :value2')
            ->setParameter('value1', $start->format('Y-m-d H:i:s'))
            ->setParameter('value2', $end->format('Y-m-d H:i:s'))
            ->groupBy('b.date')
            ->getQuery()
            ->getResult()
        ;
        
        
        

        foreach ($bookings as $booking) {

            
            $entries = 200 - $booking['seats'];
            // this create the events with your data (here booking data) to fill calendar
            // this create the events with your data (here booking data) to fill calendar
            $bookingEvent = new Event(
                $entries,
                $booking['beginAt'],
                $booking['endAt']// If the end date is null or not defined, a all day event is created.
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */

            
            $eventcolor = "";
            if ($entries >= 100) {
                $eventcolor ='green';
            } elseif($entries < 100 && $entries >= 50) {
                $eventcolor ='yellow';
            } elseif($entries < 50 && $entries >= 1) {
                $eventcolor ='orange';
            } elseif($entries < 1) {
                $eventcolor ='red';
            }
            $bookingEvent->setOptions([
                'backgroundColor' => $eventcolor,
                'textColor' => 'black',
                'borderColor' => 'green',
                'display'=>'background',
                'allDay'=>true
            ]);
            
            

            // finally, add the event to the CalendarEvent to fill the calendar

           
            $calendar->addEvent($bookingEvent);
        }
    }
}