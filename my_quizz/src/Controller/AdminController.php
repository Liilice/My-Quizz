<?php

namespace App\Controller;

use App\Form\PassewordEditType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\SecurityBundle\Security;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted(attribute: "IS_AUTHENTICATED_FULLY");
        /** @var User $user */
        $user = $this->getUser();
        return match ($user->isVerified()){
            true => $this->redirectToRoute('home'),
            false => $this->render('admin/please-verify-email.html.twig'),
        };
    }

    #[Route('/admin/profil', name: 'profil')]
    public function profil(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $formPassword = $this->createForm(PassewordEditType::class, $user);
        $formPassword->handleRequest($request);
        if($formPassword->isSubmitted() && $formPassword->isValid()){
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $formPassword->get('password')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Your password has been modified.');
        }
       return $this->render('admin/profil.html.twig', ['formPassword'=>$formPassword]);
    }
}
