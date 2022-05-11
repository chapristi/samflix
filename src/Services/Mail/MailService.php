<?php
namespace App\Services\Mail;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use \Mailjet\Resources;

class MailService implements MailServiceInterface
{


    public function __construct()
    {

    }


    public function sendMail(string $user_mail,  string $subject,string $html): void
    {



        $mj = new \Mailjet\Client('30e115abbb9efeceacf3a918c2773f8e','2ddfe2039a7a84ce802f1c9f5c7784bc',true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "chapristimailpro@gmail.com",
                        'Name' => "chapristi"
                    ],
                    'To' => [
                        [
                            'Email' => "$user_mail",
                            'Name' => "$user_mail"
                        ]
                    ],
                    'Subject' => "$subject",
                    'TextPart' => "My first Mailjet email",
                    'HTMLPart' => $html,

                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        //$response->success() && var_dump($response->getData());
    }

}