<?php

namespace App\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use App\Form\MatchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class GameController extends AbstractController
{
    /**
     * @Route("/games", name="games")
     */
    public function index(GameRepository $repo)
    {

        $games = $repo->findAllDesc();
        return $this->render('game/index.html.twig', [
            'controller_name' => 'GameController',
            'games' => $games
        ]);
    }

    /**
     * @Route("/admin/game/add", name="game_add")
     */
    public function add(Request $request, ObjectManager $manager)
    {
        $game = New Game();

        $form = $this->createForm(MatchType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($game);
            $manager->flush();
            $this->addFlash('success', 'Match Ajouté !');
            return $this->redirectToRoute('games');
        }

        return $this->render('game/add.html.twig', [
            'controller_name' => 'GameController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Game $game
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/game/edit/{id}", name="game_edit")
     */
    public function edit(Request $request, ObjectManager $manager, Game $game)
    {
        $form = $this->createForm(MatchType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->flush();
            $this->addFlash('success', 'Match Modifié !');
            return $this->redirectToRoute('game');
        }

        return $this->render('game/edit.html.twig', [
            'controller_name' => 'GameController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/game", name="game")
     */
    public function admin(GameRepository $repo)
    {

        $games = $repo->findAllDesc();
        return $this->render('game/admin.html.twig', [
            'controller_name' => 'GameController',
            'games' => $games
        ]);
    }


}
