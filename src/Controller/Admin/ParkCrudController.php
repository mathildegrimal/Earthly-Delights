<?php

namespace App\Controller\Admin;

use App\Entity\Park;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ParkCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Park::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
