<?php

namespace App\Controller\Admin;

use App\Entity\SerieUpload;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class SerieUploadCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SerieUpload::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            yield AssociationField::new('serie')
                ->setFormTypeOptions([
                    'by_reference' => true
                ])
                ->autocomplete(),
            yield AssociationField::new('upload')
                ->setFormTypeOptions([
                    'by_reference' => true,
                ])
                ->autocomplete(),
        ];
    }

}
