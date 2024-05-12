<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController {

    #[Route("/",name : "home")]
    public function index (CategorieRepository $repository) {
        $categories = $repository->findAll();
        return $this->render('accueil.html.twig', ['categories'=>$categories]);
    }

    #[Route("/historique",name : "historique.show")]
    public function showHistory(Request $request): Response{
        $array=$request->cookies->all();
        $result = [];
        if($this->getUser()){
            $result = [];
        }else{
            $array=$request->cookies->all();
            $result = [];
            foreach($array as $key=>$value){
                $cookie_value = urldecode($key);
                if($key != "PHPSESSID"){
                    if(str_contains($cookie_value, "\n")){
                        $name = str_replace("\n", "", $cookie_value);
                        $result[$name] = $value;
                    }else{
                        $result[$cookie_value] = $value;
                    }
                }
            }
        }
        return $this->render('historique.html.twig', ['result'=>$result]);
    }

}
