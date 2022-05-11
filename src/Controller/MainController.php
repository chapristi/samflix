<?php

namespace App\Controller;

use App\Repository\CategoriesOfUploadRepository;
use App\Repository\CategoryRepository;
use App\Repository\HistoricalRepository;
use App\Repository\SerieRepository;
use App\Repository\SerieUploadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]

    public function index(HistoricalRepository $historicalRepository , CategoriesOfUploadRepository $categoriesOfUploadRepository,Request $request, SerieRepository $serie, CategoryRepository $categoryRepository,SerieRepository $serieRepository): Response
    {

        if($this->getUser()){
            if ($request->request->get("search")){
               $result = $serie->findBysearch(["name" =>(string)$request->request->get("search")]);
                return $this->render('main/search.html.twig', [
                    "result" => $result
                ]);
            }
            $historical = $historicalRepository->findBy(["user"=>$this->getUser()]);

            $categorie = $categoryRepository->findAll();
            $serie = $categoriesOfUploadRepository->findAll();
            return $this->render('main/connected.html.twig', [
                "categorie" => $categorie,
                "serie" => $serie,
                "historical" => $historical
            ]);
        }
        return $this->render('main/index.html.twig', [

        ]);
    }
    #[Route('/show/{token}', name: 'show')]
    public function show($token,SerieRepository $serie, SerieUploadRepository $serieUploadRepository)

    {
        $seriefind = $serie->findOneBy(["token"=>$token]);
        $req = $serieUploadRepository->findBy(["serie"=>$seriefind->getId()]);

        if($seriefind->getCategory()==="film"){
            $token = $seriefind->getToken();
            return $this->redirectToRoute("app_player",["token"=>$token]);
        }




        return $this->render('main/show.html.twig', [
                "episodes" =>  $req,
        ]);
    }
    #[Route('/show/category/{cate}', name: 'show_by_category')]
    public function catergory(CategoriesOfUploadRepository $categoriesOfUploadRepository,$cate, SerieRepository $serieRepository, CategoryRepository $categoryRepository)
    {
        $serie = $serieRepository->findBy(["category" => $cate]);
        $category = $categoryRepository->findOneBy(["name" => $cate]);

        if ($serie) {

            return $this->render('main/show_by_category.html.twig', [
                "serie" => $serie
            ]);
        } elseif ($category) {
            $serie = $categoriesOfUploadRepository->findBy(["category" => $category->getId()]);

            return $this->render('main/show_by_category_spe.html.twig', [
                "serie" => $serie
            ]);
        } else {
            return $this->redirectToRoute("app_main");
        }


    }
    /*
    #[Route('test', name: 'test')]
    public function test(HistoricalRepository $historicalRepository , CategoriesOfUploadRepository $categoriesOfUploadRepository,Request $request, SerieRepository $serie, CategoryRepository $categoryRepository,SerieRepository $serieRepository)
    {



        $historical = $historicalRepository->findBy(["user"=>$this->getUser()]);

        $categorie = $categoryRepository->findAll();
        $serie = $categoriesOfUploadRepository->findAll();
        return $this->render('main/test.html.twig', [
            "categorie" => $categorie,
            "serie" => $serie,
            "historical" => $historical
        ]);
    }
    */




}
