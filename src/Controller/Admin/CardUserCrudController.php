<?php

namespace App\Controller\Admin;

use App\Entity\CardUser;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CardUserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CardUser::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name'),
            TextField::new('quality'),
            TextField::new('quality'),
            IntegerField::new('price'),
            //ImageField::new('img')
        ];
    }
}