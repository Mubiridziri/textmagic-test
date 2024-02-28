<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'user_tests')]
class UserTest
{
    #[ORM\Id]
    #[ORM\Column(type: "integer", nullable: false)]
    #[ORM\GeneratedValue]
    private ?int $id;

    #[ORM\Column(type: "datetime")]
    private \DateTime $occurredAt;

    #[ORM\OneToMany(targetEntity: UserTestQuestion::class, mappedBy: "test",cascade: ['persist', 'remove'])]
    #[Assert\NotBlank]
    private Collection $answers;

    public function __construct()
    {
        $this->occurredAt = new \DateTime();
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getOccurredAt(): \DateTime
    {
        return $this->occurredAt;
    }

    public function setOccurredAt(\DateTime $occurredAt): void
    {
        $this->occurredAt = $occurredAt;
    }

    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function setAnswers(Collection $answers): void
    {
        $this->answers = $answers;
    }

    public function getCorrectAnswersCount(): int
    {
        $count = 0;
        foreach ($this->answers as $answer) {
            if ($answer->isCorrect()) {
                $count++;
            }
        }
        return $count;
    }

}