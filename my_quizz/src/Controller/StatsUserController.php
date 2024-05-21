<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StatsUserController extends AbstractController
{
    #[Route('/stats/user', name: 'app_stats_user')]
    public function index(): Response
    {
        return $this->render('stats_user/index.html.twig', [
            'controller_name' => 'StatsUserController',
        ]);
    }
}
