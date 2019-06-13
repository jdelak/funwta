<?php

namespace App\Controller;

use App\Repository\ArchiveRepository;
use App\Repository\GameRepository;
use App\Repository\RankingRepository;
use App\Repository\SeasonRepository;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Player;
use App\Repository\PlayerRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\PlayerType;

class PlayerController extends AbstractController
{
    /**
     * @Route("/players", name="players")
     */
    public function index(PlayerRepository $repo)
    {
        $players = $repo->findAll();
        return $this->render('player/index.html.twig', [
            'controller_name' => 'PlayerController',
            'players' => $players,
        ]);
    }

    /**
     * @Route("/admin/player/add", name="player_add")
     */
    public function add(Request $request, ObjectManager $manager)
    {
        $player = New Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($player);
            $manager->flush();
            $this->addFlash('success', 'Joueur Ajouté !');

            return $this->redirectToRoute('player');
        }

        return $this->render('player/add.html.twig', [
            'controller_name' => 'PlayerController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Player $player
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/player/edit/{id}", name="player_edit")
     */
    public function edit(Request $request, ObjectManager $manager, Player $player)
    {
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){


            $manager->flush();

            $this->addFlash('success', 'Joueur Modifié !');

            return $this->redirectToRoute('player');
        }

        return $this->render('player/edit.html.twig', [
            'controller_name' => 'PlayerController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/player/{id}", name="player_show")
     */
    public function show($id, PlayerRepository $repo, RankingRepository $rankRepo, VideoRepository $videoRepo, GameRepository $matchRepo, ArchiveRepository $archiveRepo, SeasonRepository $seasonRepo)
    {
        $player = $repo->find($id);
        $season = $seasonRepo->findCurrentSeason();
        $currentRank = $rankRepo->findCurrentRanking($player, $season);
        $videos = $videoRepo->findVideoByPlayer($player);
        $matchs = $matchRepo->findMatchByPlayer($player);
        $archives = $archiveRepo->findArchiveByPlayer($player);
        
        return $this->render('player/show.html.twig', [
            'controller_name' => 'PlayerController',
            'player' => $player,
            'videos' => $videos,
            'matchs' => $matchs,
            'archives' => $archives,
            'ranking' => $currentRank,
             
        ]);
    }

    /**
     * @Route("/admin/player", name="player")
     */
    public function admin(PlayerRepository $repo)
    {

        $players = $repo->findAll();
        return $this->render('player/admin.html.twig', [
            'controller_name' => 'PlayerController',
            'players' => $players
        ]);
    }
}
