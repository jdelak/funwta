<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Entity\Comment;
use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="articles")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        // Retrieve the entity manager of Doctrine
        $em = $this->getDoctrine()->getManager();

        $articlesRepository = $em->getRepository(Article::class);

        $allArticlesQuery = $articlesRepository->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->getQuery();

        // Paginate the results of the query
        $articles = $paginator->paginate(
        // Doctrine Query, not results
            $allArticlesQuery,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );


        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/admin/article/add", name="article_add")
     */
    public function add(Request $request, ObjectManager $manager)
    {
        $article = New Article();

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($article);
            $manager->flush();
            $this->addFlash('success', 'Article Ajouté !');

            return $this->redirectToRoute('article');
        }

        return $this->render('article/add.html.twig', [
            'controller_name' => 'ArticleController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Article $article
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/article/edit/{id}", name="article_edit")
     */
    public function edit(Request $request, ObjectManager $manager, Article $article)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){


            $manager->flush();

            $this->addFlash('success', 'Article Modifié !');

            return $this->redirectToRoute('article');
        }

        return $this->render('article/edit.html.twig', [
            'controller_name' => 'ArticleController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/articles/{slug}", name="article_show")
     */
    public function show($slug, ArticleRepository $repo, CommentRepository $comRepo, ObjectManager $manager, Request $request)
    {
        $article = $repo->findOneBySlug($slug);
        $comments = $article->getComments();

        $manager->persist($article);
        $manager->flush();

        $user = $this->getUser();
        $comment = New Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $comment->setUser($user);
            $comment->setArticle($article);
            $manager->persist($comment);
            $manager->flush();
            $this->addFlash('success', 'Commentaire Ajouté !');
            if($request){
                $this->redirect($request->getUri());
            }

        }


        return $this->render('article/show.html.twig', [
            'controller_name' => 'ArticleController',
            'article' => $article,
            'comments' => $comments,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/article", name="article")
     */
    public function admin(ArticleRepository $repo)
    {

        $articles = $repo->findAllDesc();
        return $this->render('article/admin.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles
        ]);
    }
}
