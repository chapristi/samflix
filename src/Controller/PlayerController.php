<?php

namespace App\Controller;

use App\Entity\Historical;
use App\Repository\HistoricalRepository;
use App\Repository\SerieUploadRepository;
use App\Repository\UploadsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlayerController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager){

    }
    #[Route('/player/video/{token}', name: 'app_player')]
    public function index(SerieUploadRepository $serieUploadRepository, HistoricalRepository $historicalRepository,$token,UploadsRepository $uploadsRepository): Response
    {
        $video = $uploadsRepository->findOneBy(["token"=>$token]);

        if (!$video){
            return $this->redirectToRoute("app_main");

        }
        $history = $historicalRepository->findBy(["video"=>$video,"user"=>$this->getUser()]);
        $serieUpload = $serieUploadRepository->findOneBy(["upload"=>$video]);
        $episodes = $serieUploadRepository->findBy(["serie"=>$serieUpload->getId()]);
        $next = [];
        foreach($episodes as $episode){
            if($episode->getUpload()->getEpisode() === $video->getEpisode()+1){
                $next[] = [$episode];
            }
        }



        if (!$history){
            $historical = (new Historical())
                ->setUser($this->getUser())
                ->setVideo($video);
            ;
            $this->entityManager->persist($historical);
            $this->entityManager->flush();
        }

        return $this->render('player/index.html.twig', [
            'controller_name' => 'PlayerController',
            "next" => $next["token"] ?? ""  ,
        ]);
    }

}
