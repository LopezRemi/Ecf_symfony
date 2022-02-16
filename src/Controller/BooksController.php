<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Books;
use App\Entity\Historical;
use App\Form\BooksCreateFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BooksController extends AbstractController
{

    #[Route('/books/listing', name: 'books_listing')]
    public function booksListing(ManagerRegistry $doctrine): Response
    {
        $books = $doctrine->getRepository(Books::class)->findAll();

        return $this->render('books/listing.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/book/create', name: 'book_create')]
    public function create(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger): Response
    {
        // mise en place du gestionnaire de BDD :
        $entityManager = $doctrine->getManager();
        // cree l'objet book$book et initialise les datas
        $book = new Books();
        $form = $this->createForm(BooksCreateFormType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();


            $coverFile = $form->get('cover')->getData();
            if ($coverFile) {
                $originalFilename = pathinfo($coverFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $coverFile->guessExtension();
                $coverFile->move(
                    $this->getParameter('uploads_directory'),
                    $newFilename
                );
                $book->setCover($newFilename);
            }


            $entityManager->persist($book);
            $entityManager->flush();
            $this->addFlash('success', 'Livre ajoutée avec succes');

            return $this->redirectToRoute('books_listing');
        }

        return $this->renderForm('books/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/book/delete/{id}', name: 'book_delete')]
    public function remove(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Books::class)->find($id);


        foreach ($book->getHistoricals() as $historical) {
            $entityManager->remove($historical);
        }

        $entityManager->remove($book);
        $entityManager->flush();

        $this->addFlash('danger', 'Livre Supprimé avec succes');

        return $this->redirectToRoute('books_listing');
    }

    #[Route('/book/description/{id}', name: 'book_description', methods: ['GET'])]
    public function description(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Books::class)->findOneBy(['id' => $id]);

        if (!$book) {
            throw $this->createNotFoundException(
                "Livre non trouvé pour l'id " . $id
            );
        }

        return $this->render('books/description.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/book/loan/{id}', name: 'book_loan')]
    public function loan(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Books::class)->findOneBy(['id' => $id]);

        $form = $this->createFormBuilder($book)
            ->add('user_id', EntityType::class, [
                'label' => 'Utilisateur emprunteur :',
                'class' => User::class,
                'attr' => ['class' => 'form-control mb-4']
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Validation de l\'emprunt',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $update = $form->getData();

            $book->setUserId($update->getUserId());
            $book->setStatus(0);

            $history = new Historical;
            $history->setDateLoan(new \DateTime('now'));
            $history->setDateReturn(new \DateTime('+15 days'));
            $history->addUserId($update->getUserId());
            $history->addBookId($book);


            $entityManager = $doctrine->getManager();
            $entityManager->persist($history);
            $entityManager->flush();

            $this->addFlash('success', 'Livre emprunté avec succes');
            return $this->redirectToRoute('books_listing');
        }
        return $this->render('books/loan.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/book/return/{id}', name: 'book_return')]
    public function bookReturn(Request $request, ManagerRegistry $doctrine, int $id,): Response
    {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Books::class)->findOneBy(['id' => $id,]);
        
        foreach ($book->getHistoricals() as $historical) {
            $historical->setDateOfReturn(new \DateTime('now'));
        }

        $book->setStatus(1);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($book);
        $entityManager->flush();

        $this->addFlash('success', 'Livre rendu avec succes');
        return $this->redirectToRoute('books_listing');
    }
}
