<?php

namespace App\Controller;

use App\Repository\SeasonRepository;
use App\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\SeasonType;


class SeasonController extends AbstractController
{
    /**
     * @Route("/seasons", name="seasons")
     */
    public function index(SeasonRepository $repo, SeasonRepository $seasonRepo)
    {
        $seasons = $seasonRepo->findAll();

        return $this->render('season/index.html.twig', [
            'controller_name' => 'RankingController',
            'season' => $seasons,

        ]);
    }


    /**
     * @Route("/admin/season/add", name="season_add")
     */
    public function add(Request $request, ObjectManager $manager)
    {
        $season = New Season();

        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($season);
            $manager->flush();
            $this->addFlash('success', 'Saison Ajouté !');
            return $this->redirectToRoute('front');
        }

        return $this->render('season/add.html.twig', [
            'controller_name' => 'SeasonController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Season $season
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/season/edit/{id}", name="season_edit")
     */
    public function edit(Request $request, ObjectManager $manager, Season $season)
    {
        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->flush();
            $this->addFlash('success', 'Saison Modifié !');
            return $this->redirectToRoute('front');
        }

        return $this->render('season/edit.html.twig', [
            'controller_name' => 'SeasonController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/season", name="season")
     */
    public function admin(SeasonRepository $repo)
    {
        $seasons = $repo->findAllDesc();
        return $this->render('season/admin.html.twig', [
            'controller_name' => 'SeasonController',
            'seasons' => $seasons
        ]);
    }
}