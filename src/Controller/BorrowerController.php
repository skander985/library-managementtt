<?php

namespace App\Controller;

use App\Entity\Borrower;
use App\Form\BorrowerType;
use App\Repository\BorrowerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/borrower')]
class BorrowerController extends AbstractController
{
    #[Route('/', name: 'app_borrower_index', methods: ['GET'])]
    public function index(BorrowerRepository $borrowerRepository): Response
    {
        return $this->render('borrower/index.html.twig', [
            'borrowers' => $borrowerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_borrower_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $borrower = new Borrower();
        $form = $this->createForm(BorrowerType::class, $borrower);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($borrower);
            $entityManager->flush();

            return $this->redirectToRoute('app_borrower_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('borrower/new.html.twig', [
            'borrower' => $borrower,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_borrower_show', methods: ['GET'])]
    public function show(Borrower $borrower): Response
    {
        return $this->render('borrower/show.html.twig', [
            'borrower' => $borrower,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_borrower_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Borrower $borrower, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BorrowerType::class, $borrower);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_borrower_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('borrower/edit.html.twig', [
            'borrower' => $borrower,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_borrower_delete', methods: ['POST'])]
    public function delete(Request $request, Borrower $borrower, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$borrower->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($borrower);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_borrower_index', [], Response::HTTP_SEE_OTHER);
    }
}
