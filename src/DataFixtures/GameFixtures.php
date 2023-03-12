<?php

namespace App\DataFixtures;

use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GameFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $games = ['Pokemon', 'Magic', 'YuGiHo'];
        foreach ($games as $gameName) {
            $game = new Game();
            $game->setName($gameName);
            $game->setCreatedAt(new \DateTimeImmutable());
            $game->setUpdatedAt(new \DateTimeImmutable());
            $gameName === 'Pokemon' ? $game->setIsActive(1) : $game->setIsActive(0);
            $manager->persist($game);
        }

        $manager->flush();
    }
}
