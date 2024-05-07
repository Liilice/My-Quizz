<?php

namespace App\Entity;

use App\Repository\QuizzFailedRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizzFailedRepository::class)]
class QuizzFailed
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
    private ?\DateTimeInterface $failed_time = null;

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

    public function getFailedTime(): ?\DateTimeInterface
    {
        return $this->failed_time;
    }

    public function setFailedTime(\DateTimeInterface $failed_time): static
    {
        $this->failed_time = $failed_time;

        return $this;
    }
}
