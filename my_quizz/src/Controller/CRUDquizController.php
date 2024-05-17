<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Reponse;
use App\Form\AdminEditQuestionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CRUDquizController extends AbstractController
{
    #[Route('/administrateur/c/r/u/dquiz/editQuestion/{id}/{id_categorie}', name: 'editQuestion')]
    public function editQuestion(Request $request, EntityManagerInterface $entityManager, Question $question, int $id, int $id_categorie): Response
    {
        $form = $this->createForm(AdminEditQuestionType::class, $question);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $question->setQuestion($form->get('question')->getData());
            $entityManager->persist($question);
            $entityManager->flush();
            return $this->redirectToRoute('CrudCategorieIndex');
        }
        return $this->render('administrateur/cru_dquiz/editQuestion.html.twig', ['id'=>$id,'form'=>$form]);
    }

    #[Route('/administrateur/c/r/u/dquiz/deleteQuestion', name: 'deleteQuestion')]
    public function deleteQuestion(Question $question, EntityManagerInterface $entityManager): Response
    {
        $entityManager->getRepository(Question::class)->deleteAllReponse($id);
        $entityManager->remove($question);
        $entityManager->flush();
        return $this->redirectToRoute('CrudCategorieIndex');
    }

    #[Route('/traitementCreationQuestion/{id}', name: 'traitementCreationQuestion')]
    public function creerQuestion(Request $request, EntityManagerInterface $entityManager, int $id)
    {
        $formData = $request->request->all();
        $arr = "";
        foreach($formData as $key => $value){
            $question = new Question();
            $questionId = $question->getId();
            if(strpos($key, 'question') === 0){
                $question->setIdCategorie($id);
                $question->setQuestion($value);
                $entityManager->persist($question);
                $entityManager->flush($question);
                $questionId = $question->getId();
                $arr = $questionId."_".$key;
            }
            $questionId = $question->getId();
            if (strpos($key, 'reponse') === 0 ) {
                $reponse = new Reponse();
                $getId = explode("_", $arr)[0];
                $reponse->setIdQuestion($getId);
                $reponse->setReponse($value);
                if(str_ends_with( $key,'_1')){
                    $reponse->setReponseExpected('1');
                }else{
                    $reponse->setReponseExpected('0');
                }
            
                $entityManager->persist($reponse);
                $entityManager->flush($reponse);
            }
        }
        return $this->redirectToRoute('CrudCategorieIndex');
    }
}