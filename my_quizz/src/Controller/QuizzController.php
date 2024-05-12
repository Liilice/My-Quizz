<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Cookie;





class QuizzController extends AbstractController
{
    #[Route('/quizz/{id}', name: 'quizz.show')]
    public function index(EntityManagerInterface $entityManager, int $id): Response
    {
        $questions = $entityManager->getRepository(Question::class)->findAllByIdCategorie($id);
        $arrayReponse = [];
        foreach ($questions as $question) {
            $questionId = $question->getId();
            $arrayReponse[] = [$question,$entityManager->getRepository(Reponse::class)->findAllByIdQuestion($questionId)];
        }
        return $this->render('quizz/show.html.twig', ['arrayReponse'=>$arrayReponse, "id"=>$id]);
    }

    #[Route('/traitementReponse/{id}', name: 'traitementReponse')]
    public function traitementReponse(Request $request, EntityManagerInterface $entityManager, int $id){
        $categorie = $entityManager->getRepository(Categorie::class)->findNameCategorie($id);
        $categorieName = $categorie[0]->getName();
        $arrayReponse = $request->request->all();
        $totalQuestion = count($arrayReponse);
        $count = 0;
        foreach($arrayReponse as $reponse){
            $result = $entityManager->getRepository(Reponse::class)->findTrueReponse($reponse);
            if($result[0]->isReponseExpected() == true){
                $count ++;
            }
        }
        if($this->getUser()){
        }else{
            $response = new Response();
            $cookie = new Cookie(urlencode($categorieName), $count."/".$totalQuestion, time()+60*60*24*7, partitioned: true);
            $response->headers->setCookie($cookie);
            $response->sendHeaders();
        }
        return $this->render('quizz/showResult.html.twig', ['count'=>$count, "totalQuestion"=>$totalQuestion, "categorieName"=>$categorieName]);
    }

    
}
