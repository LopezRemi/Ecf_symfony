<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Historical;
use App\Form\UserCreateFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/users/listing', name: 'users_listing')]
    public function userList(ManagerRegistry $doctrine): Response
    {
        $users = $doctrine->getRepository(User::class)->findAll();

        return $this->render('user/listing.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/user/create', name: 'user_create')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        // mise en place du gestionnaire de BDD :
        $entityManager = $doctrine->getManager();
        // cree l'objet book$book et initialise les datas
        $user = new User();
        $form = $this->createForm(UserCreateFormType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Emprunteur ajoutée avec succes');

            return $this->redirectToRoute('users_listing');
        }

        return $this->renderForm('user/create.html.twig', [
        'form' => $form,
    ]);
    }

    #[Route('/user/profil/{id}', name: 'user_profil')]
    public function profil(Request $request, ManagerRegistry $doctrine, int $id): Response
    {   
        $entityManager = $doctrine->getManager(); 
        $user = $entityManager->getRepository(User::class)->findOneBy(['id'=>$id]);
         
        return $this->render('user/profil.html.twig', [
            'user' => $user,
        ]);
    }
}
