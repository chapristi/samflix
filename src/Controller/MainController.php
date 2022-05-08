<?php

namespace App\Controller;

use App\Repository\CategoriesOfUploadRepository;
use App\Repository\CategoryRepository;
use App\Repository\SerieRepository;
use App\Repository\SerieUploadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]

    public function index(CategoriesOfUploadRepository $categoriesOfUploadRepository,Request $request, SerieRepository $serie, CategoryRepository $categoryRepository,SerieRepository $serieRepository): Response
    {

        if($this->getUser()){
            if ($request->request->get("search")){

               $result = $serie->findBysearch(["name" =>(string)$request->request->get("search")]);


                return $this->render('main/search.html.twig', [
                    "result" => $result
                ]);
            }
            $categorie = $categoryRepository->findAll();
            $serie = $categoriesOfUploadRepository->findAll();
            return $this->render('main/connected.html.twig', [
                "categorie" => $categorie,
                "serie" => $serie
            ]);
        }
        return $this->render('main/index.html.twig', [

        ]);
    }
    #[Route('/show/{token}', name: 'show')]
    public function show($token,SerieRepository $serie, SerieUploadRepository $serieUploadRepository)

    {
        $seriefind = $serie->findOneBy(["token"=>$token]);
        $req = $serieUploadRepository->findOneBy(["id"=>$seriefind->getId()]);
        if($req->getUpload()->getCategory()==="film"){
            $token = $req->getUpload()->getToken();
            return $this->redirectToRoute("app_player",["token"=>$token]);
        }
        return $this->render('main/show.html.twig', [
                "episodes" =>  $req,
        ]);
    }


}
