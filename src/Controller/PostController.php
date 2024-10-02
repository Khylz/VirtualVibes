<?php

namespace App\Controller;
use App\Entity\Comment;
use App\Entity\Rubrik;
use App\Entity\Post;
use App\Entity\User;
use App\Form\CommentFormType;
use App\Repository\RubrikRepository;
use App\Repository\PostRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


use Twig\Extra\Intl\IntlExtension;


class PostController extends AbstractController
{
    private $repo;
    private $emi;

    public function __construct(PostRepository $repo, EntityManagerInterface $emi){
        $this->repo = $repo;
        $this->emi = $emi;
    }

    // PAGE D'ACCUEIL

    #[Route('/', name: 'app_post')]
    public function index(): Response
    {
        // Récupérer les posts
        $posts = $this->repo->findBy([], ['createdAt' => 'DESC'], 3);
        $posts2 = $this->repo->findBy([], ['createdAt' => 'DESC'], 3, 3);
        $posts3 = $this->repo->findBy([], ['createdAt' => 'DESC'], 3, 6);
    
        // Rendre le template avec les posts
        return $this->render('post/index.html.twig', [
            'posts' => $posts,
            'posts2' => $posts2,
            'posts3' => $posts3,
        ]);
    }

    // RUBRIK

    #[Route('/rubrik/rubrik/{id}', name: 'posts_by_rubrik')]
    public function postsByRubrik(Rubrik $rubrik, $id, PostRepository $prepo, RubrikRepository $rubrikRepository): Response{

        $rubrik = $rubrikRepository->find($id);

        if(!$rubrik){
            throw $this->createNotFoundException('Rubrik not found');
        }

        $posts = $prepo->findBy(['rubrik' => $rubrik], ['createdAt' => 'DESC'],3);
        $posts2 = $prepo->findBy(['rubrik' => $rubrik], ['createdAt' => 'DESC'],3,3);
        return $this->render('rubrik/rubrik.html.twig', [
        'rubrik' => $rubrik,
        'posts' => $posts,
        'posts2' => $posts2,
    ]);
    }

    // PAGE SHOW

    #[IsGranted('ROLE_USER')]
    #[Route('/post/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function showone(
        Post $post, 
        Request $req, 
        $id, 
        PostRepository $reppo, 
        EntityManagerInterface $emi, 
        CommentRepository $crepo,
        RubrikRepository $rubrikRepository
    ): Response
    {
        // Vérification du post
        if (!$post) {
            return $this->redirectToRoute('app_post');
        }

        $comments = new Comment();
        $posts = $reppo->find($id);
        $afposts = $this->repo->findBy([], ['createdAt' => 'DESC'], 6);

        // Récupérer les noms de Rubrik
        $rubrikNames = $rubrikRepository->findAllNamesAndIds();

        // Créer le formulaire
        $commentForm = $this->createForm(CommentFormType::class, $comments);
        $commentForm->handleRequest($req);

        // Traitement du formulaire de commentaire
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $user = $this->getUser();
            $comments->setUser($user);
            $comments->setPost($posts);
            $comments->setCreatedAt(new \DateTimeImmutable());

            // Persister le commentaire
            $emi->persist($comments);
            $emi->flush();

            // Rediriger pour éviter la resoumission du formulaire
            return $this->redirectToRoute('show', ['id' => $id]);
        }

        // Récupération des commentaires pour le post
        $allComments = $crepo->findByPostOrderedByCreatedAtDesc($id);

        // Rendre la vue avec les données appropriées
        return $this->render('show/show.html.twig', [
            'comments' => $allComments,
            'comment_form' => $commentForm->createView(),
            'post' => $post,
            'afposts' => $afposts,
            'rubrikNames' => $rubrikNames,
        ]);
    }

    
    // Mentions Légales

    #[Route('/mention', name: 'app_mention')]
    public function mentionlg(): Response
    {
        return $this->render('mention/mentionlg.html.twig');
    }
}
