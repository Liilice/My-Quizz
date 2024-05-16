<?php

namespace App\Controller;

use App\Entity\Categorie;
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

    #[Route('/administrateur/c/r/u/duser/addCategorie', name: 'addCategorie')]
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

    #[Route('/administrateur/c/r/u/duser/editCategorie/{id}', name: 'editCategorie')]
    public function editUser(Request $request, EntityManagerInterface $entityManager, Categorie $categorie): Response
    {
        $form = $this->createForm(AdminEditCategorieType::class, $categorie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $categorie->setName($form->get('name')->getData());
            $entityManager->persist($categorie);
            $entityManager->flush();
            return $this->redirectToRoute('CrudCategorieIndex');
        }
        return $this->render('administrateur/cru_dcategorie/editCategorie.html.twig', ['form'=>$form]);
    }

    #[Route('/administrateur/c/r/u/duser/deleteCategorie/{id}', name: 'deleteCategorie')]
    public function deleteUser(Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($categorie);
        $entityManager->flush();
        return $this->redirectToRoute('CrudCategorieIndex');
    }
}