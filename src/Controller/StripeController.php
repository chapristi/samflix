<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Services\Mail\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Checkout\Session;
use Symfony\Component\Security\Core\User\UserInterface;

class StripeController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ){

    }

    #[Route('/stripe', name: 'stripe')]
    public function index()
    {


        if(!$this->getUser()){
            return $this->redirectToRoute("app_login");
        }
        \Stripe\Stripe::setApiKey('sk_test_51JooZkDfZJsKn0Qy1MSlslsEhZKbRgY3plDJRiZPE6Nb6rx0D3I22tBuRGDqNfQuaElzqlxNre9w0cAIpsxJG3em002pyn6sHi');

        header('Content-Type: application/json');

        $YOUR_DOMAIN = 'http://localhost:8000';

        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[
                'price' => 'price_1KxyG4DfZJsKn0QyDy9OLjjb',
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/cancel/{CHECKOUT_SESSION_ID}',
        ]);

        $order = (new Order())
            ->setIdUser($this->getUser())
            ->setIsPaid(false)
            ->setSessionId($checkout_session->id);
        $this->entityManager->persist($order);
        $this->entityManager->flush();




        return $this->redirect($checkout_session->url);

        //return  new JsonResponse(['id' => $checkout_session -> id, "url"=>$checkout_session->url]);



    }

    #[Route('/success/{id}', name: 'success')]
    public function success ($id ,OrderRepository $orderRepository, UserRepository $userRepository)
    {
        $order  = $orderRepository->findOneBy(["session_id" => $id ]);
        $order->setIsPaid(true);
        $this->entityManager->persist($order);
        $order->getIdUser()->setRoles(["ROLE_VIP"]);
        $this->entityManager->flush();
        $mail = new MailService();
        $mail->sendMail("louis.bec05@gmail.com","payment accpeted","<h3>Hey juste pour te dire : </h3><br />Ton achat a bien été effectué tu es maintenant VIP, reviens vite nous voir ");
        return $this->redirectToRoute("app_main");


    }
    #[Route('/cancel/{id}', name: 'cancel')]
    public function cancel ()
    {

        $this->redirectToRoute("app_main");


    }


}
