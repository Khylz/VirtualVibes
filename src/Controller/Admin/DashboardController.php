<?php

namespace App\Controller\Admin;

namespace App\Controller\Admin;

use App\Repository;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Users;
use App\Entity\Rubrik;
use App\Entity\Comment;

use App\Repository\UserRepository;
use App\Repository\PostRepository;
use App\Repository\RubrikRepository;
use App\Repository\CommentRepository;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

// use App\Service\PostService;
// use App\Service\UserCountService;


class DashboardController extends AbstractDashboardController
{
    protected $userRepository;
    protected $postRepository;
    protected $commentRepository;
    protected $rubrikRepository;
   
    public function __construct(
        UserRepository $userRepository,
        PostRepository $postRepository,
        CommentRepository $commentRepository,
        RubrikRepository $rubrikRepository
    ){
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
        $this->rubrikRepository = $rubrikRepository;
    }



    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        if($this->isGranted('ROLE_EDITOR')){
            // Récupérer les statistiques
            $stats = [
                'users' => $this->userRepository->count([]),
                'posts' => $this->postRepository->count([]),
                'comments' => $this->commentRepository->count([]),
                'rubriks' => $this->rubrikRepository->count([]),
                'recentPosts' => $this->postRepository->findBy([], ['createdAt' => 'DESC'], 5),
                'recentComments' => $this->commentRepository->findBy([], ['createdAt' => 'DESC'], 5),
            ];

            return $this->render('admin/dashboard.html.twig', [
                'stats' => $stats
            ]);
        } else {
            return $this->redirectToRoute('app_post');
        }
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('VirtualVibes - ');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Go To Site', 'text-white fa-solid fa-arrow-rotate-left', 'app_post');

        if($this->isGranted('ROLE_ADMIN'))
        yield MenuItem::linkToDashboard('Dashboard', ' text-white fas fa-home')->setPermission('ROLE_SUPER_ADMIN');

        if($this->isGranted('ROLE_EDITOR')){
            yield MenuItem::section('Posts');
            yield MenuItem::subMenu('Posts', 'text-white fa-sharp fa-solid fa-blog')->setSubItems([
                  MenuItem::linkToCrud('Create Posts', 'fas fa-newspaper', Post::class)->setAction(Crud::PAGE_NEW),
                  MenuItem::linkToCrud('Show Posts', 'fas fa-eye', Post::class)
            ]);
        }

        if($this->isGranted('ROLE_MODO')){
            yield MenuItem::section('Comments');
            yield MenuItem::subMenu('Comments', 'text-white fa-solid fa-comment')->setSubItems([
                // MenuItem::linkToCrud('Create Comments', 'fas fa-newspaper', Comment::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Show Comments', 'fas fa-eye', Comment::class)
                ]);   
        }   
                
         if($this->isGranted('ROLE_ADMIN')){
            yield MenuItem::section('Rubriks');
            yield MenuItem::subMenu('Rubriks', 'text-white fa-solid fa-book-open-reader')->setSubItems([
                MenuItem::linkToCrud('Create Rubriks', 'fas fa-newspaper', Rubrik::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Show Rubriks', 'fas fa-eye', Rubrik::class)
                ]);     
                
        }
                
         if($this->isGranted('ROLE_SUPER_ADMIN')){
            yield MenuItem::section('Users');
            yield MenuItem::subMenu('Users', 'text-white fa-solid fa-circle-user')->setSubItems([
                MenuItem::linkToCrud('Create User', 'fas fa-newspaper', User::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Show User', 'fas fa-eye', User::class)
                ]);     
        }     
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        if(!$user instanceof User){
            throw new \Exception('Wrong user');
        }
        $avatar = 'divers/avatars/' . $user->getAvatar();
        return parent::configureUserMenu($user)
        ->setAvatarUrl($avatar);
    }

    



}
