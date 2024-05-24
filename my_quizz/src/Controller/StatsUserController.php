<?php

namespace App\Controller;

use App\Entity\QuizzPassed;
use App\Entity\Categorie;
use App\Repository\QuizzPassedRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class StatsUserController extends AbstractController
{
    #[Route('/stats/user', name: 'app_stats_user')]
    public function index(QuizzPassedRepository $quizzPassedRepository, EntityManagerInterface $entityManager): Response
    {
        $categorieAll = $entityManager->getRepository(Categorie::class)->findAll();
        $array = [];
        foreach($categorieAll as $categorie){
            $averagePoints = $entityManager->getRepository(QuizzPassed::class)->findSumCategorie($categorie->getName());
            $totalUsers = $entityManager->getRepository(QuizzPassed::class)->findTotalUserForCategorie($categorie->getName());
            $array[$categorie->getName()] = [$averagePoints,$totalUsers ];
        }
        return $this->render('stats_user/index.html.twig', [
            'array' => $array,
        ]); 
    }
}