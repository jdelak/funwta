<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Video;
use App\Repository\VideoRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\VideoType;

class VideoController extends AbstractController
{
    /**
     * @Route("/videos", name="videos")
     */
    public function index(VideoRepository $repo)
    {
        $videos = $repo->findAllDesc();
        return $this->render('video/index.html.twig', [
            'controller_name' => 'VideoController',
            'videos' => $videos
        ]);
    }

    /**
     * @Route("/admin/video/add", name="video_add")
     */
    public function add(Request $request, ObjectManager $manager)
    {
        $video = New Video();
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($video);
            $manager->flush();
            $this->addFlash('success', 'Video Ajouté !');

            return $this->redirectToRoute('video');
        }

        return $this->render('video/add.html.twig', [
            'controller_name' => 'VideoController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Video $video
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/video/edit/{id}", name="video_edit")
     */
    public function edit(Request $request, ObjectManager $manager, Video $video)
    {
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){


            $manager->flush();

            $this->addFlash('success', 'Vidéo Modifié !');

            return $this->redirectToRoute('video');
        }

        return $this->render('video/edit.html.twig', [
            'controller_name' => 'VideoController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/video", name="video")
     */
    public function admin(VideoRepository $repo)
    {
        $videos = $repo->findAllDesc();
        return $this->render('video/admin.html.twig', [
            'controller_name' => 'VideoController',
            'videos' => $videos,
        ]);
    }
}
