<?php

namespace App\Service;

use App\Entity\UserTest;
use Doctrine\ORM\EntityManagerInterface;

readonly class UserTestService
{
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    /**
     * Ideally, you should use pagination here. For example,
     * for twig you can connect a awesome KnpLabs/KnpPaginatorBundle.
     * However, the task didn’t say anything, so I decided not to bother too much.
     * @return array
     */
    public function getUserTests(): array
    {
        return $this->manager->getRepository(UserTest::class)->findBy([], ['id' => "desc"]);
    }
}