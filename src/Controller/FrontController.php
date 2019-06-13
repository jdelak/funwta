<?php

namespace App\Controller;

use App\Repository\GameRepository;
use App\Repository\ArticleRepository;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class FrontController extends AbstractController
{
    /**
     * @Route("/", name="front")
     */
    public function index(ArticleRepository $repo, GameRepository $matchRepo, VideoRepository $videoRepo)
    {
        $articles = $repo->findLast();
        $matchs = $matchRepo->findAllDesc();
        $videos = $videoRepo->findAllDesc();
        
        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
            'articles' => $articles,
            'matches' => $matchs,
            'videos' => $videos,
        ]);
    }

    /**
     * @Route("/faq", name="faq")
     */
    public function faq(){

        return $this->render('front/faq.html.twig', [
            'controller_name' => 'FrontController',
            ]);
    }

}
