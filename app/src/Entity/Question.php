<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
#[ORM\Table(name: 'questions')]
class Question
{
    #[ORM\Id]
    #[ORM\Column(type: "integer", nullable: false)]
    #[ORM\GeneratedValue]
    private ?int $id;

    #[ORM\Column(type: "text")]
    private string $title;

    #[ORM\OneToMany(targetEntity: QuestionOption::class, mappedBy: "question", cascade: ['persist', 'remove'])]
    private Collection $options;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function setOptions(Collection $options): void
    {
        $this->options = $options;
    }
}