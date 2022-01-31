<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 60)]
    private $firstName;

    #[ORM\Column(type: 'string', length: 60)]
    private $lastName;

    #[ORM\Column(type: 'string', length: 60)]
    private $email;

    #[ORM\Column(type: 'array', nullable: true)]
    private $loan = [];

    #[ORM\OneToMany(mappedBy: 'User_id', targetEntity: Books::class)]
    private $books_id;

    public function __construct()
    {
        $this->books_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLoan(): ?array
    {
        return $this->loan;
    }

    public function setLoan(?array $loan): self
    {
        $this->loan = $loan;

        return $this;
    }

    /**
     * @return Collection|Books[]
     */
    public function getBooksId(): Collection
    {
        return $this->books_id;
    }

    public function addBooksId(Books $booksId): self
    {
        if (!$this->books_id->contains($booksId)) {
            $this->books_id[] = $booksId;
            $booksId->setUserId($this);
        }

        return $this;
    }

    public function removeBooksId(Books $booksId): self
    {
        if ($this->books_id->removeElement($booksId)) {
            // set the owning side to null (unless already changed)
            if ($booksId->getUserId() === $this) {
                $booksId->setUserId(null);
            }
        }

        return $this;
    }
}
