<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class QuestionRepository extends EntityRepository
{
    /**
     * Return shuffled App\Entity\Question array with help Doctrine Function
     * @return array|null
     */
    public function getShuffledQuestions(): ?array
    {
        $query = $this->createQueryBuilder('q');
        $query->orderBy('Random()');
        return $query->getQuery()->getResult();
    }
}