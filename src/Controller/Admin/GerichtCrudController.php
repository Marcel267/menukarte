<?php

namespace App\Controller\Admin;

use App\Entity\Gericht;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GerichtCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Gericht::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            ImageField::new('bild')->setUploadDir('public/bilder/'),
            TextField::new('beschreibung'),
            NumberField::new('preis'),
            AssociationField::new('kategorie'),
        ];
    }
}
