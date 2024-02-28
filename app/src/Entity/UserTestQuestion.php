<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'user_test_questions')]
#[UniqueEntity(fields: ['test', 'question'], message: "В рамках этого теста на этот вопрос уже указан такой ответ")]
class UserTestQuestion
{
    #[ORM\Id]
    #[ORM\Column(type: "integer", nullable: false)]
    #[ORM\GeneratedValue]
    private ?int $id;

    #[ORM\ManyToOne(targetEntity: UserTest::class, inversedBy: "answers")]
    #[Assert\NotBlank]
    private UserTest $test;

    #[ORM\ManyToOne(targetEntity: Question::class)]
    #[Assert\NotBlank]
    private Question $question;

    #[ORM\Id]
    #[ORM\ManyToMany(targetEntity: QuestionOption::class)]
    #[Assert\NotBlank]
    private Collection $answerOptions;

    public function __construct(UserTest $test = null, Question $question = null, array $answerOptions = [])
    {
        $this->test = $test;
        $this->question = $question;
        $this->answerOptions = new ArrayCollection($answerOptions);
    }

    public function getTest(): UserTest
    {
        return $this->test;
    }

    public function setTest(UserTest $test): void
    {
        $this->test = $test;
    }

    public function getQuestion(): Question
    {
        return $this->question;
    }

    public function setQuestion(Question $question): void
    {
        $this->question = $question;
    }

    public function getAnswerOptions(): Collection
    {
        return $this->answerOptions;
    }

    public function setAnswerOptions(Collection $answerOptions): void
    {
        $this->answerOptions = $answerOptions;
    }

    public function isCorrect(): bool
    {
        /** @var QuestionOption $option */
        foreach ($this->answerOptions as $option) {
            if (!$option->isCorrect()) {
                return false;
            }
        }
        return true;
    }


    public function getCorrectAnswers(): array
    {
        $answers = [];
        foreach ($this->question->getOptions() as $option) {
            if ($option->isCorrect()) {
                $answers[] = $option;
            }
        }

        return $answers;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }
}