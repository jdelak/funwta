<?php

namespace App\Controller;

use App\Repository\RankingRepository;
use App\Repository\SeasonRepository;
use App\Entity\Ranking;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\RankingType;


class RankingController extends AbstractController
{
    /**
     * @Route("/rankings", name="rankings")
     */
    public function index(RankingRepository $repo, SeasonRepository $seasonRepo)
    {
        $season = $seasonRepo->findCurrentSeason();
        $rankings = $repo->findAllByPointsDesc($season);

        return $this->render('ranking/index.html.twig', [
            'controller_name' => 'RankingController',
            'season' => $season,
            'rankings' => $rankings,
        ]);
    }


    /**
     * @Route("/admin/ranking/add", name="ranking_add")
     */
    public function add(Request $request, ObjectManager $manager)
    {
        $ranking = New Ranking();

        $form = $this->createForm(RankingType::class, $ranking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager->persist($ranking);
            $manager->flush();
            $this->addFlash('success', 'Classement Ajouté !');
            return $this->redirectToRoute('front');
        }

        return $this->render('ranking/add.html.twig', [
            'controller_name' => 'RankingController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Ranking $ranking
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/ranking/edit/{id}", name="ranking_edit")
     */
    public function edit(Request $request, ObjectManager $manager, Ranking $ranking)
    {
        $form = $this->createForm(RankingType::class, $ranking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager->flush();
            $this->addFlash('success', 'Classement Modifié !');
            return $this->redirectToRoute('front');
        }

        return $this->render('ranking/edit.html.twig', [
            'controller_name' => 'RankingController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/ranking", name="admin_ranking")
     */
    public function admin(Request $request, RankingRepository $repo, SeasonRepository $seasonRepo)
    {
        $seasons = $seasonRepo->findAllDesc();
        $season = '';
        $rankings = '';

        if($request->getMethod() === 'POST'){
            $season = $request->request->get('season');
            $rankings = $repo->findAllByPointsDesc($season);
        }
        return $this->render('ranking/admin.html.twig', [
            'controller_name' => 'RankingController',
            'seasons' => $seasons,
            'season' => $season,
            'rankings' => $rankings,
        ]);
    }
}