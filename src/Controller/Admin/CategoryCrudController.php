<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            yield TextField::new('name'),
            yield ImageField::new('image')
                ->setBasePath('uploads/img')
                ->setUploadDir('public/uploads/img/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                -> setRequired(false),
        ];
    }

}
