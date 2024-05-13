<?php

namespace App\Entity;

use App\Repository\QuizzPassedRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizzPassedRepository::class)]
class QuizzPassed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $id_user = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $id_quizz = null;

    #[ORM\Column]
    private ?int $note = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $passed_time = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdQuizz(): ?Categorie
    {
        return $this->id_quizz;
    }

    public function setIdQuizz(?Categorie $id_quizz): static
    {
        $this->id_quizz = $id_quizz;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getPassedTime(): ?\DateTimeInterface
    {
        return $this->passed_time;
    }

    public function setPassedTime(\DateTimeInterface $passed_time): static
    {
        $this->passed_time = $passed_time;

        return $this;
    }
}
