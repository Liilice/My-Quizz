<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Question;



class QuizzController extends AbstractController
{
    #[Route('/quizz/{id}', name: 'quizz.show')]
    public function index(EntityManagerInterface $entityManager, int $id): Response
    {
        $questions = $entityManager->getRepository(Question::class)->findAllByIdCategorie($id);
        return $this->render('quizz/show.html.twig', ['questions'=> $questions]);
    }
}
