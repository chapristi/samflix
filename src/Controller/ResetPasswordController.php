<?php

namespace App\Controller;

use App\Entity\ResetPassword;
use App\Repository\ResetPasswordRepository;
use App\Repository\UserRepository;
use App\Services\Mail\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager){}
    #[Route('/reset/password/{email}', name: 'app_reset_password')]
    public function index($email,UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneByEmail($email);
        if (!$user) {
            return $this->redirectToRoute("app_main");
        }
        $token = Uuid::uuid4();
        $reset = (new ResetPassword())
            ->setUser($user)
            ->setToken($token);
        $this->entityManager->persist($reset);
        $this->entityManager->flush();
        $mail = new MailService();
        $mail->sendMail($user->getEmail(),"reset password",$token);

        return $this->redirectToRoute("app_main");


    }
    #[Route('/reset/verif/{token}', name: 'app_reset_password')]
    public function verif(UserRepository $userRepository,$token,ResetPasswordRepository $resetPassword,Request $request): Response
    {
        $reset= $resetPassword->findOneBy(["token" => $token]);
        if (!$reset) {
            return $this->redirectToRoute("app_main");
        }
        if($request->request->get("password")){
            $user  = $userRepository->findOneBy(["id" => $reset->getUser()->getId()]);
            $user->setPassword($request->request->get("password"));
        }


        return $this->render('reset_password/index.html.twig', [

        ]);





    }
}
