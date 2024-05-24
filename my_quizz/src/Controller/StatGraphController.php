<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class StatGraphController extends AbstractController
{
    // #[Route('/stat/graph', name: 'app_stat_graph')]
    // public function index(ChartBuilderInterface  $chartBuilder): Response
    // {
    //     $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

    //     $chart->setData([
    //         'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
    //         'datasets' => [
    //             [
    //                 'label' => 'My First dataset',
    //                 'backgroundColor' => 'rgb(255, 99, 132)',
    //                 'borderColor' => 'rgb(255, 99, 132)',
    //                 'data' => [0, 10, 5, 2, 20, 30, 45],
    //             ],
    //         ],
    //     ]);

    //     $chart->setOptions([
    //         'scales' => [
    //             'y' => [
    //                 'suggestedMin' => 0,
    //                 'suggestedMax' => 100,
    //             ],
    //         ],
    //     ]);
    //     return $this->render('stat_graph/index.html.twig', [
    //         'chart' => $chart,
    //     ]);
    // }

    #[Route('/stat/graph', name: 'app_stat_graph')]
    public function index(): Response
    {
       
        return $this->render('stat_graph/index.html.twig');
    }
}
