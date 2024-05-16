<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminEditUserType;
use App\Form\AdminAddUserType;
use App\Form\SetAdminType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\Attribute\Route;

class CRUDuserController extends AbstractController
{
    #[Route('/administrateur/c/r/u/duser', name: 'CrudUserIndex')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $userId = $this->getUser()->getId();
        $allUser = $entityManager->getRepository(User::class)->findAllUser($userId);
        $users =[];
        foreach($allUser as $user){
            $users[$user->getId()] = $user->getEmail();
        }
        return $this->render('administrateur/cru_duser/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/administrateur/c/r/u/duser/addUser', name: 'addUser')]
    public function addUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(AdminAddUserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setEmail($form->get('email')->getData());
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('CrudUserIndex');
        }

        return $this->render('administrateur/cru_duser/addUser.html.twig', ['form'=>$form]);
    }

    #[Route('/administrateur/c/r/u/duser/editUser/{id}', name: 'editUser')]
    public function editUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager, User $user): Response
    {
        // dd($user);
        $form = $this->createForm(AdminEditUserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setEmail($form->get('email')->getData());
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('CrudUserIndex');

        }
        $formSetAdmin = $this->createForm(SetAdminType::class);
        $formSetAdmin->handleRequest($request);
        if($formSetAdmin->isSubmitted() && $formSetAdmin->isValid()){
            $user->setRoles($formSetAdmin->get('roles')->getData());
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('CrudUserIndex');
        }
        return $this->render('administrateur/cru_duser/editUser.html.twig', ['form'=>$form, 'formSetAdmin'=>$formSetAdmin]);
    }

    #[Route('/administrateur/c/r/u/duser/deleteUser/{id}', name: 'deleteUser')]
    public function deleteUser(User $user, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('CrudUserIndex');
    }
}
