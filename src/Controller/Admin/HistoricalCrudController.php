<?php

namespace App\Controller\Admin;

use App\Entity\Historical;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class HistoricalCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Historical::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            yield AssociationField::new('user')
                ->setFormTypeOptions([
                    'by_reference' => true,
                ])
                ->autocomplete(),
            yield AssociationField::new('video')
                ->setFormTypeOptions([
                    'by_reference' => true,
                ])
                ->autocomplete(),
            yield TimeField::new('created_at')


        ];
    }

}
