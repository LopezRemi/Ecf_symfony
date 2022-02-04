<?php

namespace App\Entity;

use App\Repository\BooksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BooksRepository::class)]
class Books
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $title;

    #[ORM\Column(type: 'string', length: 60)]
    private $author;

    #[ORM\Column(type: 'string', length: 255)]
    private $summary;

    #[ORM\Column(type: 'date')]
    private $release_date;

    #[ORM\Column(type: 'string', length: 50)]
    private $category;

    #[ORM\Column(type: 'string', length: 50)]
    private $book_condition;

    #[ORM\Column(type: 'string', length: 50)]
    private $editor;

    #[ORM\Column(type: 'boolean')]
    private $status;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'books_id')]
    private $User_id;


    #[ORM\ManyToMany(targetEntity: Historical::class, mappedBy: 'bookId')]
    private $historicals;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $cover;

    public function __construct()
    {
        $this->historicals = new ArrayCollection();
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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate(\DateTimeInterface $release_date): self
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getBookCondition(): ?string
    {
        return $this->book_condition;
    }

    public function setBookCondition(string $book_condition): self
    {
        $this->book_condition = $book_condition;

        return $this;
    }

    public function getEditor(): ?string
    {
        return $this->editor;
    }

    public function setEditor(string $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->User_id;
    }

    public function setUserId(?User $User_id): self
    {
        $this->User_id = $User_id;

        return $this;
    }

    

    /**
     * @return Collection|Historical[]
     */
    public function getHistoricals(): Collection
    {
        return $this->historicals;
    }

    public function addHistorical(Historical $historical): self
    {
        if (!$this->historicals->contains($historical)) {
            $this->historicals[] = $historical;
            $historical->addBookId($this);
        }

        return $this;
    }

    public function removeHistorical(Historical $historical): self
    {
        if ($this->historicals->removeElement($historical)) {
            $historical->removeBookId($this);
        }

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }
}
