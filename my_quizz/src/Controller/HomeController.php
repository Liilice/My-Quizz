<?php

namespace App\Controller;

use App\Entity\QuizzPassed;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;


class HomeController extends AbstractController {

    #[Route("/",name : "home")]
    public function index (CategorieRepository $repository) {
        $categories = $repository->findAll();
        return $this->render('accueil.html.twig', ['categories'=>$categories]);
    }

    #[Route("/historique",name : "historique.show")]
    public function showHistory(Request $request, EntityManagerInterface $entityManager): Response{
        $result = [];
        if($this->getUser()){
            $user_id = $this->getUser()->getId();
            $arrayQuizzPassByUser = $entityManager->getRepository(QuizzPassed::class)->findQuizzPassedByUser($user_id);
            if(empty($arrayQuizzPassByUser)){
            }else{
                if(count($arrayQuizzPassByUser)>1){
                    foreach($arrayQuizzPassByUser as $value){
                        $name = $value['categorie_name'];
                        $result[$name] =$value['note'];
                    }
                }else{
                    $name = $arrayQuizzPassByUser[0]['categorie_name'];
                    $result[$name] = $arrayQuizzPassByUser[0]['note'];
                }
            }
        }else{
            $array=$request->cookies->all();
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