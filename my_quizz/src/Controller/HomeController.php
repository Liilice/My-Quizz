<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController {

    #[Route("/",name : "home")]
    public function index (CategorieRepository $repository) {
        $categories = $repository->findAll();
        return $this->render('accueil.html.twig', ['categories'=>$categories]);
    }
}
