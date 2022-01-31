<?php

namespace App\Controller;

use App\Entity\Books;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class BooksController extends AbstractController
{
    #[Route('/books', name: 'books')]
    public function index(): Response
    {
        return $this->render('books/index.html.twig', [
            'controller_name' => 'BooksController',
        ]);
    }


    #[Route('/books/listing', name: 'books_listing')]
    public function booksListing(ManagerRegistry $doctrine): Response
    {

        $books = $doctrine->getRepository(Books::class)->findAll();

        return $this->render('books/listing.html.twig', [
            'books' => $books,
        ]);
    }


}
