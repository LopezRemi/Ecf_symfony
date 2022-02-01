<?php

namespace App\Entity;

use App\Repository\HistoricalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistoricalRepository::class)]
class Historical
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToMany(targetEntity: Books::class, inversedBy: 'historicals')]
    private $bookId;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'historicals')]
    private $userId;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateLoan;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateReturn;

    public function __construct()
    {
        $this->bookId = new ArrayCollection();
        $this->userId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Books[]
     */
    public function getBookId(): Collection
    {
        return $this->bookId;
    }

    public function addBookId(Books $bookId): self
    {
        if (!$this->bookId->contains($bookId)) {
            $this->bookId[] = $bookId;
        }

        return $this;
    }

    public function removeBookId(Books $bookId): self
    {
        $this->bookId->removeElement($bookId);

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserId(): Collection
    {
        return $this->userId;
    }

    public function addUserId(User $userId): self
    {
        if (!$this->userId->contains($userId)) {
            $this->userId[] = $userId;
        }

        return $this;
    }

    public function removeUserId(User $userId): self
    {
        $this->userId->removeElement($userId);

        return $this;
    }

    public function getDateLoan(): ?\DateTimeInterface
    {
        return $this->dateLoan;
    }

    public function setDateLoan(?\DateTimeInterface $dateLoan): self
    {
        $this->dateLoan = $dateLoan;

        return $this;
    }

    public function getDateReturn(): ?\DateTimeInterface
    {
        return $this->dateReturn;
    }

    public function setDateReturn(?\DateTimeInterface $dateReturn): self
    {
        $this->dateReturn = $dateReturn;

        return $this;
    }
}
