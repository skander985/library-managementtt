<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 13)]
    private ?string $isbn = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $publishedAt = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    private ?Author $author = null;

    #[ORM\ManyToMany(targetEntity: Borrower::class, mappedBy: 'borrowedBooks')]
    private Collection $borrowers;

    public function __construct()
    {
        $this->borrowers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getBorrowers(): Collection
    {
        return $this->borrowers;
    }

    public function addBorrower(Borrower $borrower): self
    {
        if (!$this->borrowers->contains($borrower)) {
            $this->borrowers->add($borrower);
            $borrower->addBorrowedBook($this);
        }

        return $this;
    }

    public function removeBorrower(Borrower $borrower): self
    {
        if ($this->borrowers->removeElement($borrower)) {
            $borrower->removeBorrowedBook($this);
        }

        return $this;
    }
}

