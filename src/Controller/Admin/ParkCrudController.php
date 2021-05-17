<?php

namespace App\Controller\Admin;

use App\Entity\Park;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ParkCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Park::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextEditorField::new('description'),
            IntegerField::new('capacity'),
            MoneyField::new('entryprice', 'Entry Price')->setCurrency('EUR'),
            //MoneyField::new('totalIncome', 'Total Recette')->setCurrency(('EUR')),
        ];
    }
    
}
