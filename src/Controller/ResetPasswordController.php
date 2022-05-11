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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager, private UserPasswordHasherInterface $encoder){}

    #[Route('/forgot/password', name: 'forgot_password')]
    public function forgot()
    {
        return $this->render('reset_password/forgot.html.twig', [

        ]);
    }
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
        $mail->sendMail($user->getEmail(),"reset password","<h3>Salut clique ici si tu souhaite changer ton mot de passe <a href='127.0.0.1:8000/reset/verif/$token'> changer mon mot de passe </a>!</h3><br />Passez une bonne journée");

        return $this->redirectToRoute("app_main");


    }
    #[Route('/reset/verif/{token}', name: 'app_reset_verif_token')]
    public function verif(UserRepository $userRepository,$token,ResetPasswordRepository $resetPassword,Request $request): Response
    {
        $reset= $resetPassword->findOneBy(["token" => $token]);
        if (!$reset) {
            return $this->redirectToRoute("app_main");
        }

        if($request->request->get("password")){
            $user  = $userRepository->findOneBy(["id" => $reset->getUser()->getId()]);
            $user->setPassword($this->encoder->hashPassword($user,$request->request->get("password")));
            $this->entityManager->remove($reset);
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute("app_login");
        }


        return $this->render('reset_password/index.html.twig', [

        ]);





    }
}
