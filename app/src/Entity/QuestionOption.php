<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'question_options')]
class QuestionOption
{
    #[ORM\Id]
    #[ORM\Column(type: "integer", nullable: false)]
    #[ORM\GeneratedValue]
    private ?int $id;

    #[ORM\ManyToOne(targetEntity: Question::class, inversedBy: "options")]
    private Question $question;

    #[ORM\Column(type: "string")]
    private string $label;

    #[ORM\Column(type: "boolean")]
    private bool $isCorrect;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getQuestion(): Question
    {
        return $this->question;
    }

    public function setQuestion(Question $question): void
    {
        $this->question = $question;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    public function setIsCorrect(bool $isCorrect): void
    {
        $this->isCorrect = $isCorrect;
    }
}