<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Books;
use App\Entity\Historical;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
        $book->setStatus(true);
        $form = $this->createFormBuilder($book)
            ->add('title', TextType::class, [
                'label' => 'Titre du livre :',
                'attr' => [
                    'class' => 'form-control mb-4'
                ]
            ])
            ->add('author', TextType::class, [
                'label' => 'Auteur du livre :',
                'attr' => [
                    'class' => 'form-control mb-4'
                ]
            ])
            ->add('release_date', DateType::class, [
                'label' => 'Date de parution du livre :',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control mb-4'
                ]
            ])
            ->add('summary', TextareaType::class, [
                'label' => 'R??sum?? du livre :',
                'attr' => [
                    'class' => 'form-control mb-4'
                ]
            ])
            ->add('category', TextType::class, [
                'label' => 'Genre du livre :',
                'attr' => [
                    'class' => 'form-control mb-4'
                ]
            ])
            ->add('editor', TextType::class, [
                'label' => 'Editeur du livre :',
                'attr' => [
                    'class' => 'form-control mb-4'
                ]
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Disponibilit?? du livre :',
                'attr' => [
                    'class' => 'form-control mb-4'
                ],
                'choices' => [
                    'Emprunte' => '0',  // 0 quand emprunter
                    'Disponible' => '1', // 1 quand disponible
                ],
            ])
            ->add('book_condition', ChoiceType::class, [
                'label' => 'Etat du livre :',
                'attr' => [
                    'class' => 'form-control mb-4'
                ],
                'choices' => [
                    'bon' => 'Bon ??tat',
                    'passable' => 'Etat passable',
                    'mauvais' => 'Mauvais ??tat',
                ],
            ])
            ->add('cover', FileType::class, [
                'label' => 'Votre cover :',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '512k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/svg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Merci de choisir un cover valide ".jpg ,.jpeg ,.svg ,.png" et inf??rieur ?? 512Ko.',
                    ])
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Cr???? le livre',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();


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
            $this->addFlash('success', 'Livre ajout??e avec succes');

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

        $this->addFlash('danger', 'Livre Supprim?? avec succes');

        return $this->redirectToRoute('books_listing');
    }

    #[Route('/book/description/{id}', name: 'book_description', methods: ['GET'])]
    public function description(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Books::class)->findOneBy(['id' => $id]);


        $data = [
            'id' => $book->getId(),
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'summary' => $book->getSummary(),
            'release_date' => $book->getReleaseDate(),
            'category' => $book->getCategory(),
            'book_condition' => $book->getBookCondition(),
            'editor' => $book->getEditor(),
            'status' => $book->getStatus(),
            'user_id' => $book->getUserId(),
            'cover' => $book->getCover(),
        ];

        if (!$book) {
            throw $this->createNotFoundException(
                "Livre non trouv?? pour l'id " . $id
            );
        }

        return $this->render('books/description.html.twig', [
            'data' => $data,
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

            $this->addFlash('success', 'Livre emprunt?? avec succes');
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
