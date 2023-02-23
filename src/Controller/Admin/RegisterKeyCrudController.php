<?php

namespace App\Controller\Admin;

use App\Entity\RegisterKey;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RegisterKeyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RegisterKey::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new( 'key_code' );
        yield BooleanField::new( 'status' );
        yield AssociationField::new('structures')
            ->setFormTypeOption('by_reference', false)
            ->autocomplete();
        yield AssociationField::new('cohorts')
            ->setFormTypeOption('by_reference', false)
            ->autocomplete();
    }
}
