<?php

namespace App\Controller;

use App\Entity\User;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,

    ){}
    #[Route('/register', name: 'register')]
    public function inscription(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $notification = null;
        $user = new  User();




        if($request->getMethod() == 'POST'){

            $sameMail  = $this->entityManager-> getRepository(User::class)->findOneByEmail($request->request->get("email"));
            if(!$sameMail){
                $password = $encoder->hashPassword($user,$request->request->get("password"));
                $user->setPassword($password);
                $user->setEmail($request->request->get("email"));
                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $notification = "Votre inscription s'est correctement déroulée ";
            }else{
                $notification = "L'email renseigné ne peut pas etre utilisé";
            }
        }
        return $this->render('user/inscription.html.twig', [
            "notification" => $notification
        ]);
    }


}
