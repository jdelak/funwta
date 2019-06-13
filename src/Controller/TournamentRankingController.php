<?php

namespace App\Controller;

use App\Repository\TournamentRankingRepository;
use App\Repository\TournamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\TournamentRanking;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\TournamentRankingType;

class TournamentRankingController extends AbstractController
{
    /**
     * @Route("/admin/tournament_ranking", name="tournament_ranking")
     */
    public function index(Request $request, TournamentRankingRepository $repo, TournamentRepository $tournRepo)
    {
        $tournaments = $tournRepo->findAllDesc();
        $rankings = '';
        $tournament = '';
            
        if($request->getMethod() === 'POST'){
            $tournament = $request->request->get('tournament');
            $rankings = $repo->findByTournament($tournament);
        }
        return $this->render('tournament_ranking/index.html.twig', [
            'controller_name' => 'TournamentRankingController',
            'tournaments' => $tournaments,
            'tournament' => $tournament,
            'rankings' => $rankings,
        ]);
    }

    /**
     * @Route("/admin/tournament_ranking/add", name="tournament_ranking_add")
     */
    public function add(Request $request, ObjectManager $manager)
    {
        $ranking = New TournamentRanking();

        $form = $this->createForm(TournamentRankingType::class, $ranking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($ranking);
            $manager->flush();
            $this->addFlash('success', 'Ligne Classement Ajouté !');
            return $this->redirectToRoute('front');
        }

        return $this->render('tournament_ranking/add.html.twig', [
            'controller_name' => 'RankingController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param TournamentRanking $ranking
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/tournament_ranking/edit/{id}", name="tournament_ranking_edit")
     */
    public function edit(Request $request, ObjectManager $manager, TournamentRanking $ranking)
    {
        $form = $this->createForm(TournamentRankingType::class, $ranking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->flush();
            $this->addFlash('success', 'Ligne Classement Modifié !');
            return $this->redirectToRoute('front');
        }

        return $this->render('tournament_ranking/edit.html.twig', [
            'controller_name' => 'RankingController',
            'form' => $form->createView(),
        ]);
    }
}
