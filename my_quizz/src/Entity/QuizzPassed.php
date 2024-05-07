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
    private ?Users $user = null;

    #[ORM\Column]
    private ?int $categorie_id = null;

    #[ORM\Column]
    private ?int $note = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $passed_time = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCategorieId(): ?int
    {
        return $this->categorie_id;
    }

    public function setCategorieId(int $categorie_id): static
    {
        $this->categorie_id = $categorie_id;

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
