<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Entity\QuestionOption;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class LoadQuestionsFixture extends Fixture
{

    public const QUESTIONS = [
        [
            "title" => "1+1=",
            "options" => [
                ["label" => "3", "is_correct" => false],
                ["label" => "2", "is_correct" => true],
                ["label" => "0", "is_correct" => false],
            ]
        ],
        [
            "title" => "2+2=",
            "options" => [
                ["label" => "4", "is_correct" => true],
                ["label" => "3+1", "is_correct" => true],
                ["label" => "10", "is_correct" => false],
            ]
        ],
        [
            "title" => "3+3=",
            "options" => [
                ["label" => "1+5", "is_correct" => true],
                ["label" => "1", "is_correct" => false],
                ["label" => "6", "is_correct" => true],
                ["label" => "2+4", "is_correct" => true],
            ]
        ],
        [
            "title" => "4+4=",
            "options" => [
                ["label" => "8", "is_correct" => true],
                ["label" => "4", "is_correct" => false],
                ["label" => "0", "is_correct" => false],
                ["label" => "0+8", "is_correct" => true],
            ]
        ],
        [
            "title" => "5+5=",
            "options" => [
                ["label" => "6", "is_correct" => false],
                ["label" => "18", "is_correct" => false],
                ["label" => "10", "is_correct" => true],
                ["label" => "9", "is_correct" => false],
                ["label" => "0", "is_correct" => false],
            ]
        ],
        [
            "title" => "6+6=",
            "options" => [
                ["label" => "3", "is_correct" => false],
                ["label" => "9", "is_correct" => false],
                ["label" => "0", "is_correct" => false],
                ["label" => "12", "is_correct" => true],
                ["label" => "5 + 7", "is_correct" => true],
            ]
        ],
        [
            "title" => "7+7=",
            "options" => [
                ["label" => "5", "is_correct" => false],
                ["label" => "14", "is_correct" => true],
            ]
        ],
        [
            "title" => "8+8=",
            "options" => [
                ["label" => "16", "is_correct" => true],
                ["label" => "12", "is_correct" => false],
                ["label" => "9", "is_correct" => false],
                ["label" => "5", "is_correct" => false],
            ]
        ],

    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::QUESTIONS as $qst) {
            $question = new Question();
            $question->setTitle($qst["title"]);
            $options = new ArrayCollection();
            foreach ($qst["options"] as $option) {
                $questionOption = new QuestionOption();
                $questionOption->setLabel($option["label"]);
                $questionOption->setIsCorrect($option["is_correct"]);
                $questionOption->setQuestion($question);
                $options->add($questionOption);
            }
            $question->setOptions($options);
            $manager->persist($question);
        }
        $manager->flush();
    }
}