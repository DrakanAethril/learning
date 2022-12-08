<?php

namespace App\Controller\Admin;

use App\Entity\Cohort;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CohortCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cohort::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addPanel( 'Cohort infos' )->setIcon( 'fa fa-key' );
        yield TextField::new( 'name' );
        yield BooleanField::new( 'active' );
        yield AssociationField::new('structure');

        yield FormField::addPanel( 'Cohort Members' )->setIcon( 'fa fa-key' );
        yield AssociationField::new('users')
            ->setFormTypeOption('by_reference', false)
            ->autocomplete();

    }
    
}
