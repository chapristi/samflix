<?php

namespace App\Controller\Admin;

use App\Entity\Serie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SerieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Serie::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            yield TextField::new('name'),
            yield ImageField::new('image')
                ->setBasePath('uploads/img')
                ->setUploadDir('public/uploads/img/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                -> setRequired(false),
        ];
    }

}
