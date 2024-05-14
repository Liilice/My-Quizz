<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SendEmailController extends AbstractController
{
    #[Route('/send/email', name: 'app_send_email')]
    public function index(): Response
    {
        return $this->render('send_email/index.html.twig', [
            'controller_name' => 'SendEmailController',
        ]);
    }
}
