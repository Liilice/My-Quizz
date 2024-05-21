<?php

namespace App\Controller;

use App\Entity\QuizzPassed;
use App\Repository\QuizzPassedRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

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
