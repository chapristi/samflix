<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            yield IdField::new('id')->onlyOnIndex(),
            yield BooleanField::new('is_paid'),
            yield TimeField::new('created_at'),
            yield TextField::new('session_id'),
            yield AssociationField::new('id_user')
                ->setFormTypeOptions([
                    'by_reference' => true,
                ])
                ->autocomplete(),

        ];
    }

}
