<?php

namespace App\Controller;

use App\Entity\Tournament;
use App\Repository\GameRepository;
use App\Repository\TournamentRankingRepository;
use App\Repository\TournamentRepository;
use App\Form\TournamentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;


class TournamentController extends AbstractController
{
    /**
     * @Route("/tournaments", name="tournaments")
     */
    public function index(TournamentRepository $repo)
    {
        $tournaments = $repo->findAllDesc();
        return $this->render('tournament/index.html.twig', [
            'controller_name' => 'TournamentController',
            'tournaments' => $tournaments,
        ]);
    }

    /**
     * @Route("/admin/tournament/add", name="tournament_add")
     */
    public function add(Request $request, ObjectManager $manager)
    {
        $tournament = New Tournament();

        $form = $this->createForm(TournamentType::class, $tournament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($tournament);
            $manager->flush();
            $this->addFlash('success', 'Tournoi Ajouté !');
            return $this->redirectToRoute('front');
        }

        return $this->render('tournament/add.html.twig', [
            'controller_name' => 'TournamentController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Tournament $ranking
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/tournament/edit/{id}", name="tournament_edit")
     */
    public function edit(Request $request, ObjectManager $manager, Tournament $tournament)
    {
        $form = $this->createForm(TournamentType::class, $tournament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->flush();
            $this->addFlash('success', 'Tournoi Modifié !');
            return $this->redirectToRoute('front');
        }

        return $this->render('tournament/edit.html.twig', [
            'controller_name' => 'TournamentController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tournament/{id}", name="tournament_show")
     */
    public function show($id, TournamentRepository $repo, GameRepository $matchRepo, TournamentRankingRepository $rankingRepo)
    {
        $tournament = $repo->find($id);
        $matchs = $matchRepo->findMatchByTournament($tournament);
        $rankings = $rankingRepo->findByTournament($tournament);
        return $this->render('tournament/show.html.twig', [
            'controller_name' => 'TournamentController',
            'tournament' => $tournament,
            'matchs' => $matchs,
            'rankings' => $rankings,
        ]);
    }

    /**
     * @Route("/admin/tournament", name="tournament")
     */
    public function admin(TournamentRepository $repo)
    {
        $tournaments = $repo->findAllDesc();
        return $this->render('tournament/admin.html.twig', [
            'controller_name' => 'TournamentController',
            'tournaments' => $tournaments
        ]);
    }


}
