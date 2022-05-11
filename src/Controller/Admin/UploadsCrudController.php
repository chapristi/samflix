<?php

namespace App\Controller\Admin;

use App\Entity\Uploads;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Ramsey\Uuid\Uuid;

class UploadsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Uploads::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            yield IdField::new('id')->onlyOnIndex(),
            yield TextField::new('name'),
            yield ImageField::new('image')
                ->setBasePath('uploads/img')
                ->setUploadDir('public/uploads/img/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                -> setRequired(false),
            yield ImageField::new('video')
                ->setBasePath('uploads/videos')
                ->setUploadDir('public/uploads/videos/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                -> setRequired(false),
            yield  TextField::new("token")->onlyOnIndex(),
            yield  NumberField::new("episode"),
        ];
    }

}
