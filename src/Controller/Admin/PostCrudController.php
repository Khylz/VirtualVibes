<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use App\Controller\Admin\configureCrud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;



class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }
    


    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id')->onlyOnIndex(),
            TextField::new('title')->setColumns('col-md-6'),
            TextField::new('abstract')->setColumns('col-md-6'),

            TextField::new('content')->setColumns('col-md-12'),

            $image = ImageField::new('image')
                ->setUploadDir('public/divers/images')
                ->setBasePath('divers/images')
                ->setSortable(false)
                ->setFormTypeOption('required', false)->setColumns('col-md-2'),
            
            AssociationField::new('rubrik')->setColumns('col-md-2'),
            AssociationField::new('user')->setColumns('col-md-6'),
            DateField::new('createdAt')->onlyOnIndex(),
            
            BooleanField::new('is_Published')->setColumns('col-md-1')->setLabel('Publié'),

            
            TextField::new('content2')->setColumns('col-md-6'),
            TextField::new('content3')->setColumns('col-md-6'),

            TextField::new('content4')->setColumns('col-md-6'),

            TextField::new('undertitle')->setColumns('col-md-12'),
            TextField::new('undertitle2')->setColumns('col-md-6'),
            TextField::new('undertitle3')->setColumns('col-md-6'),
            
            TextField::new('undertitle4')->setColumns('col-md-6'),

        ];


    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud    
            ->setEntityLabelInSingular('Post')
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->setPaginatorPageSize(5)
            ;
    }

    //  Filtration par sont User

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('user')
            ->add('title')
            ->add('rubrik')
            ->add('createdAt')
            ;
    }
    
    public function configureActions(Actions $actions): Actions
    {
        return $actions
        ->setPermission(Action::DELETE, 'ROLE_ADMIN')
        ;
    }


    




}
