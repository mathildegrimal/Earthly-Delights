<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class BookingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Booking::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            DateTimeField::new('date'),
            IntegerField::new('nbOfSeats')
                ->setFormType(IntegerType::class, ['attr' => ['min' => 1, 'max' => 10]]),
            TextField::new('bookingRef'),
            NumberField::new('totalBookingPrice'),
            DateTimeField::new('beginAt'),
            DateTimeField::new('endAt')
        ];
    }
    
}
