<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Form\EmailEditType;
use App\Form\PassewordEditType;
use App\Form\SetAdminType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use App\Security\EmailVerifier;
use Symfony\Component\Mime\Address;
use App\Security\AppAuthenticator;
use Symfony\Contracts\Translation\TranslatorInterface;


class AdminController extends AbstractController
{
    public function __construct(private EmailVerifier $emailVerifier)
    {
    }

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

        $formEmail = $this->createForm(EmailEditType::class, $user);
        $formEmail->handleRequest($request);
        if($formEmail->isSubmitted() && $formEmail->isValid()){
            $user->setEmail($formEmail->get('email')->getData());
            $entityManager->persist($user);
            $entityManager->flush();
            $this->emailVerifier->sendEmailConfirmation('app_verify_new_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('mailer@mailer.de', 'mailer boot'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your New Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            return $this->render('admin/please-verify-new-email.html.twig');
        }

//         $formSetAdmin = $this->createForm(SetAdminType::class);
//         $formSetAdmin->handleRequest($request);
//         if($formSetAdmin->isSubmitted() && $formSetAdmin->isValid()){
//             // dd($formSetAdmin->get('roles')->getData()[0]);
//             $user->setRoles($formSetAdmin->get('roles')->getData());
//             // $entityManager = $this->getDoctrine()->getManager();
//             $entityManager->persist($user);
//             $entityManager->flush();
//             $this->addFlash('message', 'role admins');
//         }

       return $this->render('admin/profil.html.twig', ['formPassword'=>$formPassword, 'formEmail'=>$formEmail]);
    }

    #[Route('admin/please-verify-new-email.html.twig')]
    public function verify_new_email(){
        return $this->render('admin/please-verify-new-email.html.twig');
    }

    #[Route('/verify/newemail', name: 'app_verify_new_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_admin');
        }

        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('profil');
    }

    #[Route('/admin/createQuiz', name: 'app_quizz')]
    public function showCreateQuizPage(): Response
    {
        return $this->render('admin/createQuiz.html.twig');
    }

    #[Route('/traitementCreationQuizUser', name: 'traitementCreationQuizUser')]
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
        return $this->redirectToRoute('home');
    }

}
