<?php

namespace App\Controller;

use App\Repository\VideoRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerVideoController extends AbstractController
{
    #[Route('/customer/video/{id}', name: 'customer_video')]
    public function index($id, VideoRepository $videoRepository): Response
    {
        $video = $videoRepository->find($id);

        if(!$video)
        {
            return $this->redirectToRoute("home");
        }

        return $this->render('customer_video/video.html.twig', [
            'video' => $video
        ]);
    }
}
