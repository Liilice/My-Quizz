<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Form\AdminAddCategorieType;
use App\Form\AdminEditCategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategorieRepository;

class CRUDcategorieController extends AbstractController
{
    #[Route('/administrateur/c/r/u/dcategorie', name: 'CrudCategorieIndex')]
    public function index(CategorieRepository $repository): Response
    {
        $categories = $repository->findAll();
        return $this->render('administrateur/cru_dcategorie/index.html.twig', ['categories'=>$categories]);
    }

    #[Route('/administrateur/c/r/u/dcategorie/addCategorie', name: 'addCategorie')]
    public function addUser(Request $request,  EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(AdminAddCategorieType::class,  $categorie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $categorie->setName($form->get('name')->getData());
            $entityManager->persist($categorie);
            $entityManager->flush();
            return $this->redirectToRoute('CrudCategorieIndex');
        }
        return $this->render('administrateur/cru_dcategorie/addCategorie.html.twig', ['form'=>$form]);
    }

    #[Route('/administrateur/c/r/u/dcategorie/editCategorie/{id}', name: 'editCategorie')]
    public function editUser(Request $request, EntityManagerInterface $entityManager, Categorie $categorie, int $id): Response
    {
        $form = $this->createForm(AdminEditCategorieType::class, $categorie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $categorie->setName($form->get('name')->getData());
            $entityManager->persist($categorie);
            $entityManager->flush();
            return $this->redirectToRoute('CrudCategorieIndex');
        }
        return $this->render('administrateur/cru_dcategorie/editCategorie.html.twig', ['id'=>$id, 'form'=>$form]);
    }

    #[Route('/administrateur/c/r/u/dcategorie/deleteCategorie/{id}', name: 'deleteCategorie')]
    public function deleteUser(Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($categorie);
        $entityManager->flush();
        return $this->redirectToRoute('CrudCategorieIndex');
    }

    #[Route('/traitementCreationQuiz', name: 'traitementCreationQuiz')]
    public function creerQuizz(Request $request, EntityManagerInterface $entityManager)
    {
        $formData = $request->request->all();
        $categorie = new Categorie();
        $categorie->setName($formData['name']);
        $entityManager->persist($categorie);
        $entityManager->flush($categorie);
        $categorieID = $categorie->getId();
        array_shift($formData);
        $arr = "";
        foreach($formData as $key => $value){
            $question = new Question();
            $questionId = $question->getId();
            if(strpos($key, 'question') === 0){
                $question->setIdCategorie($categorieID);
                $question->setQuestion($value);
                $entityManager->persist($question);
                $entityManager->flush($question);
                $questionId = $question->getId();
                $arr = $questionId."_".$key;
            }
            if (strpos($key, 'reponse') === 0 ) {
                $reponse = new Reponse();
                $array = explode("n", $arr);
                $getId = explode("_", $arr)[0];
                $check = explode("_", $key);
                if($check[1] == $array[1]){
                    $reponse->setIdQuestion($getId);
                    $reponse->setReponse($value);
                    if(str_ends_with( $key,'_1')){
                        $reponse->setReponseExpected('1');
                    }else{
                        $reponse->setReponseExpected('0');
                    }
                }
                $entityManager->persist($reponse);
                $entityManager->flush($reponse);
            }
        }
        return $this->redirectToRoute('CrudCategorieIndex');
    }
}