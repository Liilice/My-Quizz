<?php

namespace App\Controller;

use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CRUDquizController extends AbstractController
{
    #[Route('/administrateur/c/r/u/dquiz/editQuestion/{id}', name: 'editQuestion')]
    public function editQuestion(Request $request, EntityManagerInterface $entityManager, Question $question, int $id): Response
    {
        return $this->render('administrateur/cru_dquiz/editQuestion.html.twig');
    }

    #[Route('/administrateur/c/r/u/dquiz/deleteQuestion/{id}', name: 'deleteQuestion')]
    public function deleteQuestion(Question $question, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($question);
        $entityManager->flush();
        return $this->redirectToRoute('CrudCategorieIndex');
    }
}