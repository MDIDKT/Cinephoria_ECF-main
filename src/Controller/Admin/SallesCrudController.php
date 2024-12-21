<?php

namespace App\Controller\Admin;

use App\Entity\Salles;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class SallesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn (): string
    {
        return Salles::class;
    }


    public function configureFields (string $pageName): iterable
    {
        return [
            IntegerField::new ('numeroSalle'),
            IntegerField::new ('nombreSiege'),
            IntegerField::new ('nombreSiegePMR'),
        ];
    }

}
