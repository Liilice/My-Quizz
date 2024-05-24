<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\QuizzPassed;

class StatGraphController extends AbstractController
{
    #[Route('/stat/graph', name: 'app_stat_graph')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $now = new DateTime();
        $nowForHours = new DateTime();
        $nowForWeek = new DateTime();
        $nowForMonth = new DateTime();
        $nowForYear = new DateTime();
        $last24Hours = $nowForHours->modify('-24 hours');
        $lastWeek = $nowForWeek->modify('-1 week');
        $lastMonth = $nowForMonth->modify('-1 month');
        $lastYear = $nowForYear->modify('-1 year');

        $countHours = $entityManager->getRepository(QuizzPassed::class)->findNumberOfQuizTaken($last24Hours, $now);
        $countWeek = $entityManager->getRepository(QuizzPassed::class)->findNumberOfQuizTaken($lastWeek, $now);
        $countMonth = $entityManager->getRepository(QuizzPassed::class)->findNumberOfQuizTaken($lastMonth, $now);
        $countYear =$entityManager->getRepository(QuizzPassed::class)->findNumberOfQuizTaken($lastYear, $now);
        return $this->render('stat_graph/index.html.twig', [
            'countYear'=>$countYear[0][1],
            'countMonth'=>$countMonth[0][1],
            'countWeek'=>$countWeek[0][1],
            'countHours'=>$countHours[0][1],
        ]);
    }
}
