<?php

namespace App\Service;

use App\Entity\Question;
use App\Entity\QuestionOption;
use App\Entity\UserTest;
use App\Entity\UserTestQuestion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class QuestionService
{
    public function __construct(private EntityManagerInterface $manager, private ValidatorInterface $validator)
    {
    }

    public function getShuffledQuestions(): array
    {
        $questions = $this->manager->getRepository(Question::class)->getShuffledQuestions();

        if (null === $questions) {
            return [];
        }

        return $questions;
    }

    public function getUserTestResults(array $items): UserTest
    {
        $userTest = new UserTest();
        $testAnswers = new ArrayCollection();

        /**
         * Perhaps we should have collected all the identifiers and requested them at once,
         * instead of requesting each iteration. However, if I were writing an API,
         * the symfony/serializer would work as it is written now and request each iteration.
         */
        foreach ($items as $item) {
            $question = $this->manager->getRepository(Question::class)->findOneBy(['id' => $item['id']]);
            $questionAnswer = array_map(
                fn($id) => $this->manager->getRepository(QuestionOption::class)->findOneBy(['id' => $id]),
                $item['answers']
            );
            $testQuestions = new UserTestQuestion($userTest, $question, $questionAnswer);
            $testAnswers->add($testQuestions);
        }
        $userTest->setAnswers($testAnswers);

        $this->manager->persist($userTest);
        $this->manager->flush();

        return $userTest;
    }

    /**
     * This foolish function is needed to display the
     * test results to show the questions in the same order
     * as they were during the test. The fact is that the receiving and
     * sending requests are different, and another random event has already
     * occurred. Therefore, we have to resort to this.
     * Perhaps there are more effective methods.
     * @param array $questions
     * @param array $formValues
     * @return array
     */
    public function sortQuestionBy(array $questions, array $formValues): array
    {
        $orderedQuestions = [];
        foreach ($formValues as $item) {
            $id = intval($item['id']);
            foreach ($questions as $question) {
                if ($question->getId() === $id) {
                    $orderedQuestions[] = $question;
                }
            }
        }
        return $orderedQuestions;
    }

    /**
     * ds
     * @param array $items
     * @param array<Question> $questions
     * @return string|null
     */
    public function validate(array $items, array $questions): ?string
    {
        $constraints = $this->getValidatorConstraintsFor();

        //Validate data structure
        $errors = $this->validator->validate($items, $constraints);
        if ($errors->count() > 0) {
            return "В данных нет ответов на все вопросы";
        }

        //Validate that each of the data contains all the necessary questions.
        $questionsIds = array_map(fn($item) => $item->getId(), $questions);
        foreach ($items as $item) {
            if (false !== $key = array_search(intval($item["id"]), $questionsIds)) {
                unset($questionsIds[$key]);
                continue;
            }
            return "В данных присутствует идентификатор вопроса, которого нет в БД";
        }

        if (count($questionsIds) > 0) {
            return "В данных нет ответов на все вопросы";
        }

        return null;
    }

    /**
     * @return Constraint
     */
    private function getValidatorConstraintsFor(): Constraint
    {
        return new All([
            new Collection([
                'id' => new NotBlank(),
                'answers' => new NotBlank()
            ]),
        ]);
    }
}