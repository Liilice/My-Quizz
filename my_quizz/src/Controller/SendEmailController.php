<?php

namespace App\Controller;

use App\Entity\LastLogin;
use App\Entity\User;
use App\Entity\QuizzPassed;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Mime\Address;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Mailer\MailerInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class SendEmailController extends AbstractController
{
    #[Route('/administrateur/sendEmail', name: 'app_send_email')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        return $this->render('administrateur/sendEmail/index.html.twig', [
            'controller_name' => 'SendEmailController',
        ]);
    }

    #[Route('/passOneOrManyQuiz', name: 'passOneOrManyQuiz')]
    public function passOneOrManyQuiz(EntityManagerInterface $entityManager, MailerInterface $mailer){
        $AllUserPassed = $entityManager->getRepository(QuizzPassed::class)->findAllUserPassed();
        foreach($AllUserPassed as $UserPassed){
            foreach($UserPassed as $userId){
                $user = $entityManager->getRepository(User::class)->findUserById($userId);
                $email = (new TemplatedEmail())
                    ->from(new Address('admin@mailer.de', 'mailer boot'))
                    ->to($user[0]->getEmail())
                    ->subject('Pass Quiz')
                    ->html("<p>Merci d'avoir fait un ou plusieurs quiz!</p>");
                $mailer->send($email);
            }
        }
        $this->addFlash('success', 'Email envoyer au utilisateurs.');
        return $this->redirectToRoute('app_send_email');
    }

    #[Route('/notPassOneOrManyQuiz', name: 'notPassOneOrManyQuiz')]
    public function notPassOneOrManyQuiz(EntityManagerInterface $entityManager, MailerInterface $mailer){
        $AllUserPassed = $entityManager->getRepository(QuizzPassed::class)->findAllUserPassed();
        $username = [];
        foreach($AllUserPassed as $UserPassed){
            foreach($UserPassed as $userId){
                $username[] = $userId;
            }
        }
        $users = $entityManager->getRepository(User::class)->findUserNotInParameter($username);
        foreach($users as $user){
            $email = (new TemplatedEmail())
                ->from(new Address('admin@mailer.de', 'mailer boot'))
                ->to($user->getEmail())
                ->subject('Not Pass Quiz')
                ->html("<p>Veuillez faire un ou plusieurs quiz s'il vous plait !</p>");
            $mailer->send($email);
        }
        $this->addFlash('success', 'Email envoyer au utilisateurs.');
        return $this->redirectToRoute('app_send_email');
    }

    #[Route('/loginInOneMonth', name: 'loginInOneMonth')]
    public function loginInOneMonth(EntityManagerInterface $entityManager, MailerInterface $mailer){
        $userId = $entityManager->getRepository(LastLogin::class)->findUserLoginInOneMonth();
        foreach($userId as $id){
            $user = $entityManager->getRepository(User::class)->findUserById($id["user_id"]);
            $email = (new TemplatedEmail())
                ->from(new Address('admin@mailer.de', 'mailer boot'))
                ->to($user[0]->getEmail())
                ->subject('Login')
                ->html("<p>Merci de vous être connecter au moins une fois depuis ce mois</p>");
            $mailer->send($email);

        }
        $this->addFlash('success', 'Email envoyer au utilisateurs.');
        return $this->redirectToRoute('app_send_email');    
    }

    #[Route('/notLoginInOneMonth', name: 'notLoginInOneMonth')]
    public function notLoginInOneMonth(EntityManagerInterface $entityManager, MailerInterface $mailer){
        $userId = $entityManager->getRepository(LastLogin::class)->findUserLoginInOneMonth();
        $array_ids = [];
        foreach($userId as $id){
            $array_ids[]= $id['user_id'];
        }
        $users = $entityManager->getRepository(User::class)->findUserNotInParameter($array_ids);
        foreach($users as $user){
            $email = (new TemplatedEmail())
                ->from(new Address('admin@mailer.de', 'mailer boot'))
                ->to($user->getEmail())
                ->subject('Not Login')
                ->html("<p>Nous avons remarqué que vous ne vous êtes pas connecté depuis plus d'un mois.</p>");
            $mailer->send($email);
        }
        $this->addFlash('success', 'Email envoyer au utilisateurs.');
        return $this->redirectToRoute('app_send_email');
    }
}