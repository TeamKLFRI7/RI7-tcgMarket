<?php

namespace App\DataFixtures;

use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GameFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $game = new Game();
        $game->setName('Pokemon');
        $game->setCreatedAt(new \DateTimeImmutable());
        $game->setUpdatedAt(new \DateTimeImmutable());
        $manager->persist($game);

        $manager->flush();
    }
}
