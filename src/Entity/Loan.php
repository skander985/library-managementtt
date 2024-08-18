<?php

namespace App\Entity;

use App\Repository\LoanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoanRepository::class)]
class Loan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $borrowedAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $returnedAt = null;

    #[ORM\ManyToOne(inversedBy: 'loans')]
    private ?Borrower $borrower = null;

    #[ORM\ManyToOne]
    private ?Book $book = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorrowedAt(): ?\DateTimeInterface
    {
        return $this->borrowedAt;
    }

    public function setBorrowedAt(\DateTimeInterface $borrowedAt): self
    {
        $this->borrowedAt = $borrowedAt;

        return $this;
    }

    public function getReturnedAt(): ?\DateTimeInterface
    {
        return $this->returnedAt;
    }

    public function setReturnedAt(?\DateTimeInterface $returnedAt): self
    {
        $this->returnedAt = $returnedAt;

        return $this;
    }

    public function getBorrower(): ?Borrower
    {
        return $this->borrower;
    }

    public function setBorrower(?Borrower $borrower): self
    {
        $this->borrower = $borrower;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }
}

