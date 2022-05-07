<?php

namespace App\Controller\Admin;

use App\Entity\CategoriesOfUpload;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class CategoriesOfUploadCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategoriesOfUpload::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            yield AssociationField::new('category')
                ->setFormTypeOptions([
                    'by_reference' => true
                ])
                ->autocomplete(),
            yield AssociationField::new('Upload')
                ->setFormTypeOptions([
                    'by_reference' => true,
                ])
                ->autocomplete(),
        ];
    }

}
